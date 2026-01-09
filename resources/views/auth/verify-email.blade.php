<x-layouts.marketing :title="'Verify Email - ' . config('app.name')">
    <section class="relative overflow-hidden">
        <div class="max-w-2xl mx-auto px-4 py-24">
            <div class="glass-card p-8">
                <h1 class="text-2xl font-bold text-white mb-4">Verify your email address</h1>
                <p class="text-surface-300 mb-6">
                    Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
                    If you didn't receive the email, you can request another below.
                </p>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-accent-500/20 border border-accent-500/50 text-accent-300 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-primary">Resend Verification Email</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-ghost">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layouts.marketing>
