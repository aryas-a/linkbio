<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    /**
     * Show login form
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request): RedirectResponse
    {
        $key = 'login:' . $request->ip();

        // Rate limiting
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => "Too many login attempts. Please try again in {$seconds} seconds."]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid credentials.']);
        }

        RateLimiter::clear($key);

        $user = Auth::user();

        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account has been suspended.']);
        }

        $request->session()->regenerate();

        return $user->isAdmin()
            ? redirect()->intended(route('admin.index'))
            : redirect()->intended(route('dashboard'));
    }

    /**
     * Show registration form
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'username' => 'required|string|min:3|max:50|regex:/^[a-z0-9_]+$/|unique:profiles,username',
        ], [
            'username.regex' => 'Username can only contain lowercase letters, numbers, and underscores.',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create profile
        $this->profileService->create($user, [
            'username' => $validated['username'],
            'display_name' => $validated['username'],
        ]);

        // TEMP: Auto-verify the email to skip verification flow during development
        if (method_exists($user, 'markEmailAsVerified')) {
            $user->markEmailAsVerified();
        } else {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user);

        return $user->isAdmin()
            ? redirect()->route('admin.index')->with('success', 'Welcome, Admin!')
            : redirect()->route('dashboard')->with('success', 'Welcome! Your account has been created.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle password reset request
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Always show success to prevent email enumeration
        return back()->with('status', 'If an account exists, a password reset link has been sent.');
    }
}
