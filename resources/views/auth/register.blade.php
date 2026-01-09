<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign Up - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-surface-950 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 mb-8">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <span class="text-2xl font-bold text-white">LinkBio</span>
        </a>

        <!-- Card -->
        <div class="glass-card p-8">
            <h1 class="text-2xl font-bold text-white text-center mb-2">Create your account</h1>
            <p class="text-surface-400 text-center mb-8">Start sharing your links in minutes</p>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 text-red-300 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{ username: '{{ old('username', '') }}' }">
                @csrf

                <div class="form-group">
                    <label for="username" class="input-label">Username</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-surface-500">linkbio.io/</span>
                        <input type="text" id="username" name="username" x-model="username" required
                               class="input-field pl-24" placeholder="yourname"
                               pattern="[a-z0-9_]+" minlength="3" maxlength="50">
                    </div>
                    <p class="text-surface-500 text-xs mt-1">Only lowercase letters, numbers, and underscores</p>
                </div>

                <div class="form-group">
                    <label for="email" class="input-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="input-field" placeholder="you@example.com">
                </div>

                <div class="form-group">
                    <label for="password" class="input-label">Password</label>
                    <input type="password" id="password" name="password" required
                           class="input-field" placeholder="Min 8 characters">
                    <p class="text-surface-500 text-xs mt-1">At least 8 characters with letters and numbers</p>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="input-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="input-field" placeholder="Confirm your password">
                </div>

                <button type="submit" class="btn-primary w-full">
                    Create Account
                </button>

                <p class="text-center text-surface-500 text-xs">
                    By signing up, you agree to our
                    <a href="{{ route('terms') }}" class="text-primary-400 hover:underline">Terms</a> and
                    <a href="{{ route('privacy') }}" class="text-primary-400 hover:underline">Privacy Policy</a>
                </p>
            </form>

            <p class="text-center text-surface-400 text-sm mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300">Log in</a>
            </p>
        </div>
    </div>
</body>
</html>
