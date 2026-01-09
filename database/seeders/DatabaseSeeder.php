<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Free Plan
        Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'description' => 'Get started with the essentials',
            'price' => 0,
            'billing_cycle' => 'monthly',
            'max_links' => 10,
            'max_social_links' => 5,
            'custom_themes' => false,
            'remove_branding' => false,
            'custom_domain' => false,
            'advanced_analytics' => false,
            'priority_support' => false,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Create Pro Plan
        Plan::create([
            'name' => 'Pro',
            'slug' => 'pro',
            'description' => 'Everything you need to grow',
            'price' => 9.99,
            'billing_cycle' => 'monthly',
            'max_links' => -1,
            'max_social_links' => -1,
            'custom_themes' => true,
            'remove_branding' => true,
            'custom_domain' => false,
            'advanced_analytics' => true,
            'priority_support' => false,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Create Business Plan
        Plan::create([
            'name' => 'Business',
            'slug' => 'business',
            'description' => 'For professionals and teams',
            'price' => 29.99,
            'billing_cycle' => 'monthly',
            'max_links' => -1,
            'max_social_links' => -1,
            'custom_themes' => true,
            'remove_branding' => true,
            'custom_domain' => true,
            'advanced_analytics' => true,
            'priority_support' => true,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Create Admin User
        $admin = User::create([
            'email' => 'admin@linkbio.io',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $admin->id,
            'username' => 'admin',
            'display_name' => 'Admin',
            'bio' => 'LinkBio Administrator',
            'is_published' => true,
        ]);

        // Create Demo User
        $demo = User::create([
            'email' => 'demo@linkbio.io',
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $profile = Profile::create([
            'user_id' => $demo->id,
            'username' => 'demo',
            'display_name' => 'Demo User',
            'bio' => 'This is a demo profile. Create your own free account!',
            'background_type' => 'gradient',
            'gradient_start' => '#8b5cf6',
            'gradient_end' => '#06b6d4',
            'button_color' => '#8b5cf6',
            'is_published' => true,
        ]);

        // Add demo links
        $profile->links()->createMany([
            ['title' => '🌐 My Website', 'url' => 'https://example.com', 'position' => 0],
            ['title' => '📧 Contact Me', 'url' => 'mailto:hello@example.com', 'position' => 1],
            ['title' => '📺 YouTube Channel', 'url' => 'https://youtube.com', 'position' => 2],
            ['title' => '🎨 Portfolio', 'url' => 'https://example.com/portfolio', 'position' => 3],
        ]);

        // Add social links
        $profile->socialLinks()->createMany([
            ['platform' => 'twitter', 'url' => 'https://x.com/demo', 'position' => 0],
            ['platform' => 'instagram', 'url' => 'https://instagram.com/demo', 'position' => 1],
            ['platform' => 'github', 'url' => 'https://github.com/demo', 'position' => 2],
        ]);
    }
}
