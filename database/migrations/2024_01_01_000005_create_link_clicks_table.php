<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('link_id')->constrained()->cascadeOnDelete();
            $table->string('ip_hash', 64);
            $table->string('user_agent', 500)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('device_type', 20)->nullable();
            $table->timestamp('clicked_at');
            
            $table->index(['link_id', 'clicked_at']);
            $table->index(['link_id', 'ip_hash', 'clicked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_clicks');
    }
};
