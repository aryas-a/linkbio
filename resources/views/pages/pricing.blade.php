<x-layouts.marketing :title="'Pricing - ' . config('app.name')">
    <section class="py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-6">Simple, transparent pricing</h1>
                <p class="text-lg text-surface-400">Start free. Upgrade when you need more.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Free -->
                <div class="glass-card p-8">
                    <h3 class="text-xl font-bold text-white mb-2">Free</h3>
                    <p class="text-surface-400 mb-6">Get started for free</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-white">$0</span>
                        <span class="text-surface-400">/month</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Up to 10 links
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            5 social links
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Basic analytics
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-secondary w-full">Get Started</a>
                </div>

                <!-- Pro -->
                <div class="glass-card p-8 border-primary-500 relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 bg-primary-500 text-white text-sm font-medium rounded-full">Popular</div>
                    <h3 class="text-xl font-bold text-white mb-2">Pro</h3>
                    <p class="text-surface-400 mb-6">For growing creators</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-white">$9.99</span>
                        <span class="text-surface-400">/month</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Unlimited links
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            All social links
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Custom themes
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Remove branding
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Advanced analytics
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-primary w-full">Start Free Trial</a>
                </div>

                <!-- Business -->
                <div class="glass-card p-8">
                    <h3 class="text-xl font-bold text-white mb-2">Business</h3>
                    <p class="text-surface-400 mb-6">For professionals</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-white">$29.99</span>
                        <span class="text-surface-400">/month</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Everything in Pro
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Custom domain
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Priority support
                        </li>
                        <li class="flex items-center gap-2 text-surface-300">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Team accounts
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-secondary w-full">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.marketing>
