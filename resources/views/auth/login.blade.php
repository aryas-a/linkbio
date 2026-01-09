<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Log In - {{ config('app.name') }}</title>

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
            <h1 class="text-2xl font-bold text-white text-center mb-2">Welcome back</h1>
            <p class="text-surface-400 text-center mb-8">Log in to your account</p>

            @if(session('status'))
            <div class="mb-6 p-4 bg-accent-500/20 border border-accent-500/50 text-accent-300 rounded-xl text-sm">
                {{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 text-red-300 rounded-xl text-sm">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="form-group">
                    <label for="email" class="input-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-field" placeholder="you@example.com">
                </div>

                <div class="form-group">
                    <label for="password" class="input-label">Password</label>
                    <input type="password" id="password" name="password" required
                           class="input-field" placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-surface-600 bg-surface-800 text-primary-500 focus:ring-primary-500">
                        <span class="text-sm text-surface-400">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-400 hover:text-primary-300">Forgot password?</a>
                </div>

                <button type="submit" class="btn-primary w-full">
                    Log in
                </button>
            </form>

            <p class="text-center text-surface-400 text-sm mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300">Sign up</a>
            </p>
        </div>
    </div>
</body>
</html>
