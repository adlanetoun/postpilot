# 2. Pages and Views

## 1. Global Layouts

We strictly utilize two native Laravel 11 Blade layouts, heavily leveraging DaisyUI component classes to enforce consistency and eliminate JS framework bloat.

*   **`resources/views/layouts/guest.blade.php`**: Used for Auth routes. Centered card layout. Includes only Tailwind/DaisyUI base CSS. No navigation partials.
*   **`resources/views/layouts/app.blade.php`**: Used for authenticated routes. Includes a top DaisyUI `navbar` (Logo, Project Selector Dropdown, Settings link, Logout form). No complex sidebar navigation to reduce DOM size and render time.

**CRITICAL INFRASTRUCTURE MANDATE (Abandonment Defense):** 
DaisyUI and Tailwind CSS MUST be compiled locally via Vite (`npm run build`). Under zero circumstances will we rely on external CDNs. If a CDN goes down or is abandoned, the UI must remain fully functional.

---

## 2. Exact Page Inventory

To completely eliminate UI feature creep and "Dashboard Bloat", the entire user-facing application is restricted to the following **5 routes/views**. No hidden "coming soon" pages or separate profile pages.

1.  **`/login`** (Breeze Scaffold)
2.  **`/register`** (Breeze Scaffold)
3.  **`/forgot-password`** (Breeze Scaffold)
4.  **`/`** (Project & Campaign Hub) -> The operational core.
5.  **`/settings`** (Unified Account Management)

---

## 3. Page Breakdowns

### 3.1 Auth Views (Breeze Standard)
*   **Purpose:** Email/Password authentication.
*   **Components:** Standard Laravel Breeze Blade implementations styled with DaisyUI `input-bordered` and `btn-primary` classes. No modifications to the controller logic other than capturing Timezone.

### 3.2 Project & Campaign Hub (`/`)
*   **Purpose:** The central command center. Eliminates the need for a separate "Projects List" or standalone Dashboard.
*   **State Handling:** This single route handles 3 distinct states intelligently:
    *   **State A (No Project Exists):** Renders the main layout, but overlays a DaisyUI `modal` immediately. The modal contains the "Create Project" form (Name, Description, Target Audience, Tone). POSTs to create the project and initiates AI generation.
    *   **State B (Generating - AI Working):** Displays a full-screen DaisyUI `loading` spinner. 
        *   *Session-Aware Polling (Soft Timeout):* A Vanilla JS script polls `/api/campaigns/{id}/status`. To prevent the API endpoint from poisoning Laravel's `url.intended` session key, the `fetch()` `.then()` block MUST verify the `content-type` is JSON. If it receives HTML (session expired), it MUST NOT force a reload. It must `clearInterval()` and display a DaisyUI `alert-warning` with a manual "Click here to log in" link.
        *   *Reaper Interception:* The polling JS must explicitly check for `failed_generation` (triggered by the 10-minute cron). If detected, it must `clearInterval()`, hide the spinner, and inject a DaisyUI `alert-error` with a "Retry" button, preventing an infinite spinner loop.
        *   *Success:* If status changes to `draft` or `ready`, it triggers `window.location.reload()` to render State C.
    *   **State C (Ready/Scheduled - The Grid):** Displays the 30-Day Calendar Grid.
*   **Components (State C):**
    *   **Campaign Header:** Status badge, "Approve & Schedule" button (POSTs to launch).
    *   **The 30-Day Grid:** A responsive CSS Grid. Each cell represents a Day (1-30) and contains truncated previews of the 4 platform posts.
    *   **Shared Edit Modal (Validation Safe):** Do not render 120 modals. Render ONE generic `<dialog id="edit-post-modal">` at the bottom of the layout. Clicking a day card uses Vanilla JS to populate this shared modal's `<form>` and `<textarea>`. 
    *   **Validation Fallback (No FOUC):** The form must include a hidden `modal_post_id` input. To prevent a Flash of Unstyled Content (FOUC) and ensure errors persist, the `<dialog>` tag MUST use the native HTML attribute: `@if(old('modal_post_id')) open @endif`. Do not use JS to reopen the modal on error. 
    *   **Strict Security (IDOR Defense):** The `UpdatePostController` MUST enforce `Gate::authorize('update', $post)` to prevent attackers from altering the hidden `modal_post_id` and overwriting other users' posts.

### 3.3 Settings View (`/settings`)
*   **Purpose:** Consolidates all user management into a single view utilizing DaisyUI `tabs`, preventing 3 separate page loads.
*   **Components:** (Tabs rely on URL query params, e.g., `?tab=socials`, to set the `tab-active` class. This ensures OAuth callbacks returning with errors can explicitly target the correct tab).
    *   **Tab 1: Profile:** Update name, email, password, and critically, the **Timezone** (required for scheduling).
    *   **Tab 2: Social Accounts:** 
        *   Lists X, LinkedIn, Facebook, Threads with "Connect" or "Disconnect" buttons.
        *   *Circuit Breaker UI:* If a token's `quarantined_until` flag is set, it displays a DaisyUI `badge-error` "Reconnect Required" instead of the standard "Connected" badge.
    *   **Tab 3: Billing:** Displays current Plan status (from `subscriptions` table). Features a single "Manage Billing" button that redirects to the Dodo Payments hosted customer portal.

---

## 4. Filament Admin Pages (`/admin`)

Strictly guarded by `is_admin` middleware. Utilizes Filament V3 Resources. No custom pages, only default CRUD interfaces for operational oversight.

1.  **UserResource:** View users, modify the Dodo subscription status directly to maintain the Single Source of Truth (no `is_premium` overrides).
2.  **ProjectResource:** Inspect user prompts and AI contexts.
3.  **CampaignResource:** Monitor generation batches and manually trigger retries for `failed_generation` states.
4.  **PostResource:** The massive log of all posts. Crucial for filtering by `status = failed` to inspect `error_message` payloads from failed social media API calls.
5.  **SocialAccountResource:** View OAuth states, `refresh_failures`, and `quarantined_until` timestamps. Ability to manually reset circuit breakers.
6.  **ProcessedWebhookResource:** Log of Dodo Payment webhook `event_id`s to audit billing idempotency and prevent double-provisioning.
