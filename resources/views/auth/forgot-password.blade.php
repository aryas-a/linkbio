<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot Password - {{ config('app.name') }}</title>

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
            <h1 class="text-2xl font-bold text-white text-center mb-2">Reset Password</h1>
            <p class="text-surface-400 text-center mb-8">Enter your email to receive a reset link</p>

            @if(session('status'))
            <div class="mb-6 p-4 bg-accent-500/20 border border-accent-500/50 text-accent-300 rounded-xl text-sm">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div class="form-group">
                    <label for="email" class="input-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-field" placeholder="you@example.com">
                </div>

                <button type="submit" class="btn-primary w-full">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center text-surface-400 text-sm mt-6">
                <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300">← Back to login</a>
            </p>
        </div>
    </div>
</body>
</html>
