# 3. Database Schema

## 1. Schema Overview

The schema is ruthlessly minimized for a solo-founder Micro SaaS. There are no teams, no polymorphic relations, and no generic lookup tables.

**Relationship Chain:**
*   `User` 1 -> N `Project` 1 -> N `Campaign` 1 -> N `Post`
*   `User` 1 -> N `SocialAccount`
*   `User` 1 -> 1 `Subscription`
*   `User` 1 -> N `ProcessedWebhook` (System-level idempotency log)
*   `Post` N -> 1 `SocialAccount` (Cascades on delete)

**Key Constraint (Radical Minimalist Delete):** The relationship between `SocialAccount` and `Post` strictly uses `cascadeOnDelete()`. If a user disconnects a social account, the foreign key cascades and instantly deletes ALL associated posts (both pending and historical) at the database level. This prevents fatal crashes in the queue worker and eliminates the need for fragile Eloquent Observers. Preserving "dead" posts from disconnected accounts adds zero functional value and clutters the UI.

---

## 2. Table Definitions (Laravel Migrations)

### Base Migration Requirement
SQLite does not enforce foreign keys by default. The very first migration created by Laravel (`0001_01_01_000000_create_users_table.php`) MUST contain the following directive before any table creation:

```php
use Illuminate\Support\Facades\DB;

// Inside the up() method, before Schema::create...
if (DB::getDriverName() === 'sqlite') {
    DB::statement('PRAGMA foreign_keys = ON;');
}
```

### 2.1 `users` Table
Holds authentication, UI preferences, and admin flag. No separate profiles table.

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('timezone')->default('UTC');
    $table->boolean('is_admin')->default(false);
    $table->rememberToken();
    $table->timestamps();
});
```

### 2.2 `social_accounts` Table
Stores OAuth credentials and the Circuit Breaker state. Cascades on User delete.

```php
Schema::create('social_accounts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('provider'); // 'x', 'linkedin', 'facebook', 'threads'
    $table->string('provider_user_id');
    $table->text('access_token'); // Encrypted via Crypt at runtime
    $table->text('refresh_token')->nullable(); // Encrypted via Crypt at runtime
    $table->timestamp('expires_at')->nullable();
    $table->string('scopes')->nullable();
    
    // Circuit Breaker Fields
    $table->unsignedInteger('refresh_failures')->default(0);
    $table->timestamp('quarantined_until')->nullable();

    $table->timestamps();

    $table->unique(['user_id', 'provider']);
});
```

### 2.3 `projects` Table
The product context. Cascades on User delete.

```php
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->text('description');
    $table->string('target_audience');
    $table->string('value_proposition')->nullable();
    $table->string('tone_of_voice')->nullable();
    $table->string('website_url')->nullable();
    $table->timestamps();
});
```

### 2.4 `campaigns` Table
The 30-day generation run. Cascades on Project delete.

```php
Schema::create('campaigns', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->string('status')->default('draft'); // draft, generating, ready, active, completed, failed_generation
    $table->string('raw_llm_payload_path')->nullable(); // NVMe file path for cached JSON
    $table->text('failure_reason')->nullable();
    $table->timestamps();
});
```

### 2.5 `posts` Table
The atomic publishing unit. Crucially, it has a foreign key to BOTH `campaigns` (cascading) and `social_accounts` (nullOnDelete). 

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
    $table->foreignId('social_account_id')->nullable()->constrained()->cascadeOnDelete(); // Changed to cascade to prevent phantom jobs
    $table->string('platform'); // 'x', 'linkedin', 'facebook', 'threads'
    $table->unsignedInteger('day_number'); // 1-30
    $table->text('content');
    $table->timestamp('scheduled_at')->nullable();
    $table->string('status')->default('draft'); // draft, pending, publishing, published, failed
    $table->timestamp('published_at')->nullable();
    $table->string('platform_post_id')->nullable(); // External API ID
    $table->text('error_message')->nullable();
    $table->timestamps();

    // Critical composite index for the single queue worker's scheduler query
    $table->index(['status', 'scheduled_at']);
});
```

### 2.6 `subscriptions` Table
1:1 relationship with User for Dodo Payments MoR. Cascades on User delete.

```php
Schema::create('subscriptions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('dodo_subscription_id')->unique();
    $table->string('dodo_customer_id');
    $table->string('dodo_product_id');
    $table->string('plan_name'); // e.g., 'Monthly', 'Yearly'
    $table->string('status')->default('active'); // active, past_due, canceled
    $table->timestamp('trial_ends_at')->nullable();
    $table->timestamp('ends_at')->nullable();
    $table->timestamps();
});
```

### 2.7 `processed_webhooks` Table
Append-only idempotency record for Dodo Payments. 

```php
Schema::create('processed_webhooks', function (Blueprint $table) {
    $table->id();
    $table->string('event_id')->unique(); // Dodo's unique webhook ID
    $table->string('event_type');
    $table->text('payload')->nullable();
    $table->timestamp('created_at')->nullable(); // Intentionally omitting updated_at to save disk writes. MUST define `public const UPDATED_AT = null;` in Eloquent Model.

    // Index for the Abandonment Stress-Test pruning cron
    $table->index('created_at'); 
});
```

---

## 3. SQLite Specific Optimizations

To ensure this schema survives the single-worker, high-concurrency web-traffic profile on Fly.io NVMe, the `AppServiceProvider` MUST apply the following PRAGMA configurations on every database connection:

```php
// In App\Providers\AppServiceProvider::boot()
use Illuminate\Support\Facades\DB;

public function boot(): void
{
    if (DB::getDriverName() === 'sqlite') {
        DB::statement('PRAGMA journal_mode=WAL;');          // Allows concurrent reads during writes
        DB::statement('PRAGMA busy_timeout=5000;');         // Waits 5 seconds before throwing SQLITE_BUSY
        DB::statement('PRAGMA foreign_keys=ON;');           // Enforces cascade deletes at the DB level
        DB::statement('PRAGMA synchronous=NORMAL;');        // Balances data safety with write speed on NVMe
    }
}
```

### Abandonment Stress-Test Mitigation: Webhook Pruning
Because the `processed_webhooks` table will grow indefinitely, the system requires a scheduled command `model:prune` to delete records older than 30 days. The `created_at` index mandated in the schema above ensures this deletion does not lock the database by performing a full table scan. This command must be scheduled in `routes/console.php` to run daily.

### DST Drift Prevention & Timezone Handling
SQLite stores dates as UTC strings and lacks native Timezone awareness. To prevent Daylight Saving Time (DST) drift when scheduling 30-day campaigns, the `ProcessCampaignJob` MUST NOT simply add 24 hours to a base UTC string. It must parse each day independently using the user's timezone (e.g., `Carbon::parse("Day $i 09:00", $user->timezone)->setTimezone('UTC')`) before saving. The `Post` model MUST cast `scheduled_at` to `datetime:Y-m-d H:i:s` to enforce UTC conversion.

### Webhook Concurrency Decoupling
To prevent deadlocks (SQLite `SQLITE_BUSY`) during Dodo Payments webhook processing, the FPM controller must NOT insert into the `processed_webhooks` table synchronously using `BEGIN IMMEDIATE`. The controller must immediately dispatch an asynchronous job (e.g., `ProcessDodoWebhookJob`) and return a 200 OK. The job will handle the DB insert and gracefully catch Unique Constraint violations (`SQLSTATE 23000`) caused by Dodo retries.

### Asynchronous Pre-Cleanup (Filesystem Leak Prevention)
While DB-level `cascadeOnDelete` handles row deletion instantly, it cannot delete the `raw_llm_payload_path` files on the NVMe disk. To prevent permanent storage leaks, the application MUST extract file paths *before* calling `$user->delete()` or `$project->delete()` and dispatch an async job (e.g., `CleanupFilesJob`) to physically delete the JSON payloads from the disk.

---

## 4. Laravel Scaffolding Requirements
The following standard Laravel tables are strictly required for this architecture to function. Ensure their migrations are present before deployment.

### `password_reset_tokens` (Required by Laravel Breeze)
Standard Laravel migration. Run: `php artisan make:queue:breeze-tables` (or ensure Breeze installs it).
```php
Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('email')->primary();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
```

### `sessions` (Required for Database Session Driver)
Required to enforce strict session invalidation on password change.
Run: `php artisan session:table`
```php
Schema::create('sessions', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->foreignId('user_id')->nullable()->index();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->longText('payload');
    $table->integer('last_activity')->index();
});
```

### `jobs` & `failed_jobs` (Required for Custom SQLite Queue)
Required for the `SqliteImmediateQueue` driver. 
Run: `php artisan queue:table` and `php artisan queue:failed-table`
*Note: Ensure the `jobs` table uses the standard Laravel structure. Our custom `SqliteImmediateQueue` overrides the `pop()` logic, not the schema.*
```php
// Standard jobs schema
Schema::create('jobs', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('queue')->index();
    $table->longText('payload');
    $table->unsignedTinyInteger('attempts');
    $table->unsignedInteger('reserved_at')->nullable();
    $table->unsignedInteger('available_at');
    $table->unsignedInteger('created_at');
});

// Standard failed_jobs schema
Schema::create('failed_jobs', function (Blueprint $table) {
    $table->id();
    $table->string('uuid')->unique();
    $table->text('connection');
    $table->text('queue');
    $table->longText('payload');
    $table->longText('exception');
    $table->timestamp('failed_at')->useCurrent();
});
```

### `cache` & `cache_locks` (Required for Database Cache Driver)
Required for the `database` cache driver used in X API rate limiting (`Cache::increment()`). 
Run: `php artisan cache:table`

*CRITICAL CONSTRAINT:* `Cache::increment()` performs an implicit DB write. To prevent locking the SQLite database during queue processing, `Cache::increment()` MUST be called strictly OUTSIDE of any `DB::transaction()` or `BEGIN IMMEDIATE` blocks.

```php
Schema::create('cache', function (Blueprint $table) {
    $table->string('key')->primary();
    $table->mediumText('value');
    $table->integer('expiration');
});

Schema::create('cache_locks', function (Blueprint $table) {
    $table->string('key')->primary();
    $table->string('owner');
    $table->integer('expiration');
});
```
