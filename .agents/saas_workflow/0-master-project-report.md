# Master Project Report: PostPilot (Micro SaaS)

## 1. Product Overview & Value Proposition
**The Core Idea:** A Micro SaaS platform where a user inputs their product or idea, and the tool automatically generates a 30-day cross-platform marketing content plan for 4 social media platforms. Once approved, the posts are automatically scheduled and published.
**Value Proposition:** "From Idea to 30 Days of Done-For-You Publishing in 5 Minutes."

*(Note: We MUST generate 120 unique, platform-optimized posts (30 days x 4 platforms). Generating generic posts is strictly rejected as it breaks the value proposition and violates platform constraints).*

### The User Journey
1. **Onboarding & Billing:** Registration via Laravel Breeze (Email/Password or Socialite). Instant redirection to Dodo Payments checkout for subscription activation.
2. **Social Account Linking:** OAuth flows to connect X, LinkedIn, Facebook, and Threads. Tokens securely stored.
3. **Project Creation:** User inputs Product Name, Description, Target Audience, and Tone of Voice.
4. **AI Generation:** An LLM generates 120 unique, platform-optimized text posts grouped by day.
5. **Review & Edit:** User reviews the 30-day calendar (DaisyUI UI), edits texts, and approves the campaign.
6. **Autopilot Execution:** Laravel Scheduler and Queue Workers handle daily publishing to respective platforms using stored OAuth tokens.

## 2. Core Features Breakdown
- **Authentication:** Laravel 11 native (Breeze + Blade).
- **AI Content Generation:** Uses OpenAI (gpt-4o-mini) or Anthropic. Enforces structured JSON output. Falls back and retries on failure.
- **Scheduling/Queueing:** Strictly SQLite `database` driver with mandatory mitigations.
- **Social Media Integration:** OAuth 2.0 with token refresh handling. (Instagram is excluded to focus on text-based campaigns and remove image processing overhead).
- **Billing:** Dodo Payments Webhooks for subscription lifecycle (`subscription.active`, `subscription.cancelled`).
- **Admin Panel:** Filament V3 restricted to `/admin` for user/project/post monitoring.

## 3. API & Integration Strategy
- **AI APIs:** OpenAI (gpt-4o-mini) / Anthropic for text generation. JSON mode enforced.
- **Social Media APIs:**
  - **X (Twitter):** OAuth 2.0 PKCE, `POST /2/tweets`.
  - **LinkedIn:** OAuth 2.0 Authorization Code Flow, UGC Posts API.
  - **Facebook (Pages):** OAuth 2.0, `POST /{page-id}/feed`.
  - **Threads:** OAuth 2.0, `POST /v1/threads`.

## 4. Technical Architecture (STRICT CONSTRAINTS)
**Tech Stack:** Laravel 11, SQLite (Foreign Keys ON), Pure Blade + Tailwind CSS + DaisyUI, Filament V3, Fly.io with Persistent Volumes. No external databases (No Redis).

### 4.1. SQLite & Queue Concurrency Mastery
To prevent `SQLITE_BUSY` (Database is locked) errors under load, the following architecture is **mandatory**:

1. **Custom Queue Driver (`SqliteImmediateQueue`):** We must extend Laravel's `DatabaseQueue` and override the `pop()` method to explicitly issue `DB::statement('BEGIN IMMEDIATE TRANSACTION')`. This prevents transaction upgrade deadlocks between the queue worker and web requests.
2. **Single Queue Worker:** We must run exactly ONE worker process on Fly.io: `php artisan queue:work database --sleep=3 --tries=3 --max-time=3600`.
3. **Pragmas:** `PRAGMA journal_mode=WAL;`, `PRAGMA busy_timeout=5000;`, and `PRAGMA foreign_keys=ON;` must be set in `AppServiceProvider`.
4. **Fly.io Deployment Strategy:** `fly.toml` must use `strategy = "immediate"` to prevent two VMs running simultaneously during deployments (split-brain).
5. **NVMe Volumes:** SQLite is bound by disk IOPS. Fly.io NVMe volumes are required for mass inserts to complete in ~15ms.

### 4.2. Mass Insert Mitigation
When generating 120 posts, we **cannot** use Eloquent `save()` in a loop, as it triggers 120 separate transactions and locks. We must build an array in memory and perform a single bulk insert:
`Post::insert($postsToInsert);` wrapped in `DB::transaction(..., 3, ['IMMEDIATE']);` to minimize lock duration to milliseconds.

### 4.3. The LLM API Architectural Trap
It is **STRICTLY FORBIDDEN** to wrap the entire `ProcessCampaignJob::handle()` method inside a `DB::transaction()`. The HTTP call to OpenAI/Anthropic (which takes ~15-25 seconds) must be done **outside** any transaction. Only the final `Post::insert()` must be wrapped in a transaction. This ensures the database is completely unlocked for users while the worker waits for the network.

## 5. Exhaustive Database Entities & Schema

**`users`**
- `id` (bigint, PK), `name`, `email` (unique), `password`, `timezone` (default: 'UTC')
- `ai_credits_used` (integer, default: 0)
- `remember_token`, `timestamps`, `softDeletes`

**`social_accounts`**
- `id` (bigint, PK), `user_id` (bigint, FK -> cascade)
- `platform`, `provider_id`, `provider_name`
- `access_token` (encrypted), `refresh_token` (encrypted, nullable)
- `token_scopes`, `expires_at` (timestamp, nullable)
- `timestamps` *(Hard Delete ONLY to enforce security policy on disconnect)*

**`projects`**
- `id` (bigint, PK), `user_id` (bigint, FK -> cascade)
- `name`, `description`, `target_audience`, `tone`, `default_hashtags`
- `timestamps`, `softDeletes`

**`campaigns`**
- `id` (bigint, PK), `project_id` (bigint, FK -> cascade)
- `status` (draft, generating, ready, active, completed, failed)
- `duration_days` (integer, default: 30)
- `ai_prompt_snapshot`, `ai_generation_id`, `total_input_tokens`, `total_output_tokens`
- `generation_started_at`, `generation_finished_at`
- `timestamps`, `softDeletes`

**`posts`**
- `id` (bigint, PK), `campaign_id` (bigint, FK -> cascade), `social_account_id` (bigint, FK -> cascade)
- `day` (integer), `platform`, `content`, `status`
- `scheduled_at`, `published_at`
- `platform_post_id`, `attempts` (integer, default: 0), `error_message`
- `timestamps` *(Hard Delete ONLY)*

**`subscriptions`**
- `id` (bigint, PK), `user_id` (bigint, FK -> cascade)
- `dodo_customer_id`, `dodo_subscription_id` (unique), `dodo_product_id`
- `status`, `trial_ends_at`, `ends_at`, `next_billing_at`
- `timestamps` *(Hard Delete ONLY)*

**`webhook_logs`**
- `id` (bigint, PK), `provider`, `event_type`, `event_id` (unique), `payload` (json), `processed_at`, `timestamps`

## 6. Edge Cases & Risks
- **SQLite Write Concurrency:** Solved via `BEGIN IMMEDIATE` custom queue driver and WAL mode.
- **Massive Write Spikes:** Solved via bulk in-memory array generation and `Post::insert()`.
- **LLM API Rate Limits (HTTP 429):** This is the true hidden bottleneck. We must implement Laravel's `RateLimiter` or `withoutOverlapping` middleware in the job to ensure concurrent generation requests (if they happen) do not get rate-limited by OpenAI/Anthropic.
- **Queue Worker Memory Leaks:** Handling massive JSON payloads in a long-running PHP process will leak memory. Solved by forcing the worker to restart hourly using `--max-time=3600`.
- **Social API Rate Limits:** Implemented via Laravel `RateLimiter` and tracking failed `attempts` directly on the `posts` table.
- **OAuth Token Expiration:** Proactive checking of `expires_at` and utilizing `refresh_token` before publishing jobs. Notification on failure.
- **API Idempotency:** Prevent duplicate posts by checking if `platform_post_id` is already set before publishing.

