<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('profile_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100);
            $table->string('url', 2048);
            $table->string('icon', 50)->nullable();
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('open_new_tab')->default(true);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['profile_id', 'is_active', 'position']);
            $table->index(['profile_id', 'scheduled_at', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
