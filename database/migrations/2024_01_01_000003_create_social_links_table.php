<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('profile_id')->constrained()->cascadeOnDelete();
            $table->enum('platform', [
                'instagram',
                'twitter',
                'youtube',
                'tiktok',
                'linkedin',
                'github',
                'whatsapp',
                'facebook',
                'twitch',
                'discord',
                'telegram',
                'snapchat',
                'pinterest',
                'threads',
                'email',
                'website'
            ]);
            $table->string('url', 2048);
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['profile_id', 'platform']);
            $table->index(['profile_id', 'is_active', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
