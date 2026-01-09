<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Disable transactions to allow functional/partial indexes safely
     */
    public $withinTransaction = false;

    public function up(): void
    {
        // Users: case-insensitive email lookups
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_users_lower_email ON users ((lower(email))); ");

        // Profiles: common lookups and soft deletes
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_profiles_userid_deleted ON profiles (user_id, deleted_at);");
        // Ensure one profile per user (unique index)
        DB::statement("CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS profiles_user_id_unique ON profiles (user_id);");

        // Links: soft deletes and active links ordering
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_links_profile_deleted ON links (profile_id, deleted_at);");
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_links_active ON links (profile_id, position) WHERE is_active = true;");

        // Profile views: daily aggregations
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_profile_views_date ON profile_views ((date(viewed_at))); ");

        // Link clicks: daily aggregations
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_link_clicks_date ON link_clicks ((date(clicked_at))); ");
    }

    public function down(): void
    {
        DB::statement("DROP INDEX IF EXISTS idx_users_lower_email;");
        DB::statement("DROP INDEX IF EXISTS idx_profiles_userid_deleted;");
        DB::statement("DROP INDEX IF EXISTS profiles_user_id_unique;");
        DB::statement("DROP INDEX IF EXISTS idx_links_profile_deleted;");
        DB::statement("DROP INDEX IF EXISTS idx_links_active;");
        DB::statement("DROP INDEX IF EXISTS idx_profile_views_date;");
        DB::statement("DROP INDEX IF EXISTS idx_link_clicks_date;");
    }
};
