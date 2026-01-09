<x-layouts.marketing :title="'Features - ' . config('app.name')" :description="'Discover all the features that make LinkBio the best link-in-bio platform.'">
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                    Everything you need to
                    <span class="bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">stand out</span>
                </h1>
                <p class="text-lg text-surface-400 max-w-2xl mx-auto">
                    Powerful features to help you grow your online presence and connect with your audience.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['icon' => '🎨', 'title' => 'Custom Themes', 'desc' => 'Customize every aspect of your page including colors, fonts, backgrounds, and button styles.'],
                    ['icon' => '📊', 'title' => 'Analytics', 'desc' => 'Track views, clicks, and engagement with detailed analytics and insights.'],
                    ['icon' => '📱', 'title' => 'Mobile First', 'desc' => 'Perfectly optimized for mobile devices where most of your audience is.'],
                    ['icon' => '🔗', 'title' => 'Unlimited Links', 'desc' => 'Add as many links as you need. No artificial limits.'],
                    ['icon' => '🌐', 'title' => 'Social Integration', 'desc' => 'Connect all your social profiles with beautiful icons.'],
                    ['icon' => '🔍', 'title' => 'SEO Optimized', 'desc' => 'Custom meta tags and OG images for better search rankings.'],
                    ['icon' => '⚡', 'title' => 'Fast Loading', 'desc' => 'Lightning-fast page loads for the best user experience.'],
                    ['icon' => '🔒', 'title' => 'Secure', 'desc' => 'Enterprise-grade security with HTTPS and data protection.'],
                    ['icon' => '📅', 'title' => 'Link Scheduling', 'desc' => 'Schedule links to appear or disappear at specific times.'],
                ] as $feature)
                <div class="glass-card p-6 hover:border-primary-500/50 transition-colors">
                    <div class="text-4xl mb-4">{{ $feature['icon'] }}</div>
                    <h3 class="text-xl font-semibold text-white mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-surface-400">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.marketing>
