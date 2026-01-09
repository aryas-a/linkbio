<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('username', 50)->unique();
            $table->string('display_name', 100);
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('background_image')->nullable();
            $table->enum('background_type', ['solid', 'gradient', 'image'])->default('solid');
            $table->string('background_color', 20)->default('#0f0f23');
            $table->string('gradient_start', 20)->nullable();
            $table->string('gradient_end', 20)->nullable();
            $table->string('gradient_direction', 20)->default('to-br');
            $table->string('theme', 30)->default('default');
            $table->string('font_family', 50)->default('Inter');
            $table->string('button_style', 30)->default('rounded');
            $table->string('button_color', 20)->default('#8b5cf6');
            $table->string('button_text_color', 20)->default('#ffffff');
            $table->string('text_color', 20)->default('#ffffff');
            $table->string('seo_title', 100)->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('hide_branding')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['username', 'is_published']);
            $table->index(['user_id', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
