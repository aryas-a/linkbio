<x-layouts.marketing :title="'Terms of Service - ' . config('app.name')">
    <section class="py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-white mb-8">Terms of Service</h1>
            <div class="prose prose-invert prose-surface max-w-none space-y-6 text-surface-300">
                <p>Last updated: {{ date('F d, Y') }}</p>

                <h2 class="text-2xl font-semibold text-white mt-8">1. Acceptance of Terms</h2>
                <p>By accessing or using LinkBio, you agree to be bound by these Terms of Service.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">2. Account Registration</h2>
                <p>You must provide accurate information when creating an account. You are responsible for maintaining the security of your account.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">3. Acceptable Use</h2>
                <p>You agree not to use LinkBio for any illegal or unauthorized purpose. You must not violate any laws in your jurisdiction.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">4. Content Policy</h2>
                <p>You are responsible for all content you publish. Prohibited content includes spam, malware, and illegal material.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">5. Termination</h2>
                <p>We may terminate or suspend your account at any time for violation of these terms.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">6. Contact</h2>
                <p>For questions about these Terms, contact us at legal@linkbio.io</p>
            </div>
        </div>
    </section>
</x-layouts.marketing>
