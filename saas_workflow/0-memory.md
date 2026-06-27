# Project Memory (PostPilot)

## 1. Core Identity & Stack
- **Project**: "PostPilot" (A Micro-SaaS for generating 30 days of marketing posts).
- **Stack**: Laravel 11, SQLite (WAL Mode), TailwindCSS (DaisyUI), Pure Blade components.
- **Infrastructure**: Fly.io (with 1GB persistent NVMe volume).
- **Payments**: Dodo Payments.
- **AI**: OpenAI (`gpt-4o-mini`).

## 2. Inviolable Architectural Rules
1. **Single Source of Truth**: The `subscriptions` table dictates premium access. NO `is_premium` override in the `users` table.
2. **SQLite Constraints**: 
   - Web DB and Queue DB MUST be isolated in two separate files (`database.sqlite` and `database_queue.sqlite`).
   - SQLite MUST run in `WAL` mode with `PRAGMA synchronous = NORMAL`.
   - Mass inserts must use `DB::transaction(..., 3, ['IMMEDIATE'])` to prevent lock upgrades.
3. **Frontend Rules (FOUC & Death prevention)**:
   - NO heavy JavaScript frameworks (Vue/React). Vanilla JS and Blade only.
   - NO 120 forms on a single page. Use a read-only grid with a single shared `<dialog>` modal.
4. **Resilience & Abandonment Defense**:
   - Zero-Data-Loss Webhooks: Save webhook payloads to `webhook_logs` synchronously before processing.
   - Volume Defense: Use synchronous scheduled tasks (`PruneOrphanedLLMCache`) instead of async jobs for critical file deletion to prevent `SQLITE_FULL` crashes.

## 3. Current State
- **Phase 1 (Foundation)**: ✅ Completed (Laravel, SQLite setup, Migrations, Auth, Breeze).
- **Phase 2 (Core Engine)**: ✅ Completed (OpenAI integration, Queue Job Batching, Headless headless tests).
- **Phase 3 (Subscription)**: ✅ Completed (Dodo Webhooks, Idempotency, Filament Admin, Strict Auth).
- **Phase 4 (UI Assembly)**: ⏳ Pending.
- **Phase 5 (Deployment)**: ⏳ Pending.

