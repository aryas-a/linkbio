<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Must be public and untyped to match parent in Laravel 10+
    public $withinTransaction = false;

    public function up(): void
    {
        // Composite indexes to speed up filtered time-range queries
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_profile_views_profile_viewed_at ON profile_views (profile_id, viewed_at);");
        DB::statement("CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_link_clicks_link_clicked_at ON link_clicks (link_id, clicked_at);");
    }

    public function down(): void
    {
        DB::statement("DROP INDEX IF EXISTS idx_profile_views_profile_viewed_at;");
        DB::statement("DROP INDEX IF EXISTS idx_link_clicks_link_clicked_at;");
    }
};
