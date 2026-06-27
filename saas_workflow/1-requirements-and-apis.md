# 1. Requirements and APIs

## 1. Functional Requirements

### 1.1 Authentication & Onboarding
*   **Mechanism:** Laravel Breeze (Blade) providing Email/Password authentication.
*   **Socialite Integration:** 1-click OAuth for X, LinkedIn, Facebook, and Google. Socialite handles the Authorization Code flows; custom implementations handle PKCE for X/Threads.
*   **Mandatory Verification:** Users must verify email before connecting social accounts or creating projects.
*   **Onboarding Flow:**
    1.  User connects social accounts. OAuth tokens are encrypted (`Crypt`) and stored in `social_accounts` with `provider_user_id`, `access_token`, `refresh_token`, and `token_expires_at`.
    2.  User completes billing via Dodo Payments redirect.
    3.  Dodo webhook validates signature and activates subscription.

### 1.2 Project Creation
*   **Input Schema:** User submits `name`, `description`, `target_audience`, `value_proposition`, `website_url`.
*   **Persistence:** Standard Eloquent `create()` to `projects` table.

### 1.3 AI Generation Constraints
*   **Trigger:** User clicks "Generate 30-Day Campaign" on Project view. Dispatches `GenerateCampaignPostsJob`.
*   **The LLM Contract:** The system requests a `json_object` response from the LLM. The prompt explicitly demands a JSON object where keys are days `1` through `30`. Each day contains exactly 4 keys: `x`, `linkedin`, `facebook`, `threads`. 
*   **Strict Architectural Rules:**
    1.  **NO Network I/O in Transactions:** The HTTP call to OpenAI/Anthropic MUST occur outside `DB::transaction()`.
    2.  **Durable File Caching (Credit Protection):** To prevent double-billing and queue I/O bloat, DO NOT serialize large LLM payloads into the Job object. After the HTTP call succeeds, save the raw JSON to `storage/app/campaigns/{id}.json` (NVMe persistent volume). Inside the DB transaction, read and parse this file. If the insert fails, the file remains; on retry, the Job reads the file instead of hitting the LLM API.
    3.  **Schema Validation:** Prior to database insertion, the returned JSON must be validated against a strict ruleset. If validation fails, the job throws an exception.
    4.  **Mass Insert:** Validated data is formatted into an array of 120 elements and inserted via `DB::transaction(fn() => Post::insert($data), 3, ['IMMEDIATE'])`. Individual `save()` calls are strictly prohibited.

### 1.4 Campaign Approval & Editing
*   **State Machine:** Posts are generated in `PostStatus::DRAFT`.
*   **UI:** Pure Blade calendar view. Clicking a day reveals a DaisyUI modal with 4 textareas.
*   **Editing:** Standard form POST to update individual post content.
*   **Approval:** User clicks "Approve Campaign". System calculates `scheduled_at` timestamps staggered by platform (e.g., X at 09:00, LinkedIn at 09:15) to avoid bot-detection. Post status moves to `PostStatus::APPROVED`.

### 1.5 Autopilot Publishing
*   **Scheduler:** `schedule:run` executes every minute, querying `posts` where `status = APPROVED` and `scheduled_at <= NOW()`.
*   **Dispatch:** Queries dispatch `PublishToPlatformJob`.
*   **Routing:** Utilizes PHP 8.3 `match` expression against `Platform` Enum to inject the correct API service class.

---

## 2. External APIs & .env Setup

### 2.1 AI Text Generation
**OpenAI API**
*   **Endpoint:** `POST https://api.openai.com/v1/chat/completions`
*   **Auth:** Bearer Token.
*   **.env:**
    ```env
    OPENAI_API_KEY=sk-proj-xxxx
    AI_DEFAULT_MODEL=gpt-4o-mini
    ```

**Anthropic API (Fallback)**
*   **Endpoint:** `POST https://api.anthropic.com/v1/messages`
*   **.env:**
    ```env
    ANTHROPIC_API_KEY=sk-ant-xxxx
    AI_FALLBACK_MODEL=claude-3-haiku-20240307
    ```

### 2.2 Social Media APIs

**X (Twitter) API v2**
*   **OAuth Flow:** OAuth 2.0 PKCE. Scopes: `tweet.read`, `tweet.write`, `users.read`, `offline.access`.
*   **Publish:** `POST https://api.twitter.com/2/tweets`
*   **Token Refresh:** `POST https://api.twitter.com/2/oauth2/token`
*   **.env:**
    ```env
    X_CLIENT_ID=xxxx
    X_CLIENT_SECRET=xxxx
    X_REDIRECT_URI=${APP_URL}/auth/x/callback
    ```

**LinkedIn Marketing API**
*   **OAuth Flow:** OAuth 2.0 Authorization Code. Scopes: `r_liteprofile`, `w_member_social`.
*   **Publish:** `POST https://api.linkedin.com/rest/posts` (Headers: `LinkedIn-Version: 202401`, `X-Restli-Protocol-Version: 2.0.0`).
*   **Token Refresh:** `POST https://www.linkedin.com/oauth/v2/accessToken`
*   **.env:**
    ```env
    LINKEDIN_CLIENT_ID=xxxx
    LINKEDIN_CLIENT_SECRET=xxxx
    LINKEDIN_REDIRECT_URI=${APP_URL}/auth/linkedin/callback
    ```

**Facebook Graph API (Pages)**
*   **OAuth Flow:** OAuth 2.0 Authorization Code. Scopes: `pages_show_list`, `pages_manage_posts`.
*   **Publish:** `POST https://graph.facebook.com/v19.0/{page_id}/feed`
*   **.env:**
    ```env
    FACEBOOK_CLIENT_ID=xxxx
    FACEBOOK_CLIENT_SECRET=xxxx
    FACEBOOK_REDIRECT_URI=${APP_URL}/auth/facebook/callback
    ```

**Threads API**
*   **OAuth Flow:** OAuth 2.0 (Meta infrastructure). Scopes: `threads_basic`, `threads_content_publish`.
*   **Publish (Two-Step State Trap Prevention):** Threads requires creating a container then publishing it. To prevent orphaned containers on job retry, the Job MUST persist the intermediate container ID as a public property (`?string $threadsContainerId = null`). Step 1 populates it. If Step 2 fails, the serialized job property ensures Step 1 is skipped on the retry.
    1. `POST https://graph.threads.net/v1.0/me/threads_publish` (media_type=TEXT) -> Save to `$this->threadsContainerId`.
    2. `POST https://graph.threads.net/v1.0/me/threads_publish` (creation_id=$this->threadsContainerId).
*   **.env:**
    ```env
    THREADS_APP_ID=xxxx
    THREADS_APP_SECRET=xxxx
    THREADS_REDIRECT_URI=${APP_URL}/auth/threads/callback
    ```

### 2.3 Billing
**Dodo Payments**
*   **Webhook Verification:** HMAC-SHA256 signature validation on payload.
*   **.env:**
    ```env
    DODO_API_KEY=xxxx
    DODO_WEBHOOK_SECRET=whsec_xxxx
    DODO_MONTHLY_PRODUCT_ID=xxxx
    ```

---

## 3. Strict Edge Cases & Error Handling

### 3.1 LLM Rate Limits & Failures
*   **Redundant Throttling:** Since we run a single queue worker, `RateLimiter` is redundant for LLM calls (throughput is physically limited). Remove proactive throttling to avoid unnecessary SQLite I/O.
*   **Reactive Handling (429):** If 429 is caught in `GenerateCampaignPostsJob`, parse `Retry-After` header. Execute `$this->release($retryAfterSeconds)`.
*   **Schema Validation Failure:** If LLM returns valid JSON but missing days/keys, throw `InvalidLLMResponseException`. Job increments `attempts`. After 3 attempts, fail job and update `campaigns.status` to `generation_failed`.
*   **Stale Generation Reaper (Hard Reboot Defense):** To survive VM hard-reboots where the PHP process dies silently, schedule a native cron (`schedule:run` every 5 mins) to query `Campaign::where('status', 'generating')->where('updated_at', '<', now()->subMinutes(10))->update(['status' => 'failed_generation'])`. This un-sticks campaigns and allows users to retry.

### 3.2 Social Media API Rate Limits & Rejections
*   **X API Global Limit Defense:** The X API v2 free tier is 1,500 posts/month per app. Do not use a per-minute rate limiter. Use a persistent atomic counter (e.g. Cache `increment` with monthly TTL) for X posts. Check this budget *before* dispatching publish jobs to prevent global app suspension.
*   **API Rejections (400 Bad Request):** If the platform rejects the post content (e.g., duplicate text, length exceeded), catch the exception, set `post.status = FAILED`, store the exact API error in `post.error_message`, and **do not retry**.

### 3.3 OAuth Token Expirations & The Abandonment Defense
*   **Just-in-Time Refresh (CRITICAL):** X access tokens expire every 2 hours. A nightly cron is useless for this. `PublishToPlatformJob` MUST check `token_expires_at` right before making the API call. If expired (or within 5 mins), it performs the OAuth refresh flow inline, updates the DB, and then publishes.
*   **Account-Level Circuit Breaker (Zombie Horde Prevention):** If a token refresh fails (e.g., revoked access, API deprecation), the single worker could get choked retrying 100s of failed jobs. We MUST implement a circuit breaker natively on the `social_accounts` table:
    1. Add `refresh_failures` (int) and `quarantined_until` (timestamp).
    2. On refresh failure, increment `refresh_failures`. If `>= 3`, set `quarantined_until = now()->addHours(24)`.
    3. At the top of `PublishSocialPostJob::handle()`, check `quarantined_until`. If quarantined, execute `$this->release(3600);` to bypass the HTTP call completely, freeing the worker to process healthy accounts.
    4. **Quarantine Reset:** When a user re-authenticates via Socialite Callback, the Controller MUST explicitly set `refresh_failures = 0` and `quarantined_until = null`.
    4. Delete any "nightly cron" for tokens. Use purely Just-in-Time refresh with strict `->timeout(5)` limits.

### 3.4 Webhook Idempotency & Reconciliation
*   **Security:** Dodo webhook signature MUST be cryptographically validated using `DODO_WEBHOOK_SECRET` before ANY database reads.
*   **Asynchronous Webhooks (Deadlock Prevention):** To prevent FPM from blocking on SQLite locks, the Controller must ONLY dispatch `ProcessDodoWebhookJob` and immediately return `200 OK`. Do NOT use `DB::transaction` in FPM.
*   **Worker-Level Idempotency:** Inside the Job, use `DB::transaction(..., 3, ['IMMEDIATE'])` to `INSERT` into a `processed_webhooks` table (with a `UNIQUE` constraint on `event_id`). If the `INSERT` throws a `UniqueConstraintViolation` (duplicate webhook), catch it and silently `return;`. The single worker serializes these safely without stalling the web server.

### 3.5 Billing & Access Control (Single Source of Truth)
Access control strictly relies on the `subscriptions` table via the `user.subscription` relationship. The `users` table MUST NOT contain an `is_premium` boolean flag to prevent dual-write state desynchronization.

*   **Middleware Check:** The global billing middleware verifies premium access using: `$user->subscription && $user->subscription->status === 'active'`.
*   **Eager Loading:** To optimize the single additional query, the Auth middleware must eager-load the subscription relationship: `Auth::user()->loadMissing('subscription')`.
*   **Webhook Reconciliation:** The Dodo webhook processor updates the `subscriptions` table directly. No secondary updates to the `users` table are required or permitted for access control state. A daily scheduled command `app:reconcile-subscriptions` queries the Dodo API directly for all local `subscriptions.dodo_subscription_id` records to sync the local `status` with Dodo's source of truth.
