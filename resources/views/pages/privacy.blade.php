<x-layouts.marketing :title="'Privacy Policy - ' . config('app.name')">
    <section class="py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-white mb-8">Privacy Policy</h1>
            <div class="prose prose-invert prose-surface max-w-none space-y-6 text-surface-300">
                <p>Last updated: {{ date('F d, Y') }}</p>

                <h2 class="text-2xl font-semibold text-white mt-8">1. Information We Collect</h2>
                <p>We collect information you provide directly, such as account information and profile content.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">2. How We Use Information</h2>
                <p>We use your information to provide and improve our services, and to communicate with you.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">3. Analytics</h2>
                <p>We collect anonymized analytics data to help you understand your audience. IP addresses are hashed for privacy.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">4. Data Security</h2>
                <p>We implement industry-standard security measures to protect your data.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">5. Your Rights</h2>
                <p>You can access, update, or delete your account at any time from your dashboard.</p>

                <h2 class="text-2xl font-semibold text-white mt-8">6. Contact</h2>
                <p>For privacy questions, contact us at privacy@linkbio.io</p>
            </div>
        </div>
    </section>
</x-layouts.marketing>
