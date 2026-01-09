<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AnalyticsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LinkController;
use App\Http\Controllers\Dashboard\SocialLinkController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailVerificationController;

/*
|--------------------------------------------------------------------------
| Public Marketing Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard')->group(function () {
    // Main dashboard
    Route::get('/', [DashboardController::class, 'index']);
    
    // Profile settings
    Route::get('/profile', [DashboardController::class, 'profile'])->name('.profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('.profile.update');
    Route::post('/profile/image', [DashboardController::class, 'uploadProfileImage'])->name('.profile.image');
    Route::post('/profile/background', [DashboardController::class, 'uploadBackgroundImage'])->name('.profile.background');
    
    // Appearance settings
    Route::get('/appearance', [DashboardController::class, 'appearance'])->name('.appearance');
    Route::put('/appearance', [DashboardController::class, 'updateAppearance'])->name('.appearance.update');
    
    // SEO settings
    Route::get('/seo', [DashboardController::class, 'seo'])->name('.seo');
    Route::put('/seo', [DashboardController::class, 'updateSeo'])->name('.seo.update');
    Route::post('/seo/og-image', [DashboardController::class, 'uploadOgImage'])->name('.seo.og-image');
    
    // Links management
    Route::get('/links', [LinkController::class, 'index'])->name('.links');
    Route::post('/links', [LinkController::class, 'store'])->name('.links.store');
    Route::put('/links/{link}', [LinkController::class, 'update'])->name('.links.update');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('.links.destroy');
    Route::post('/links/{link}/toggle', [LinkController::class, 'toggle'])->name('.links.toggle');
    Route::post('/links/{link}/duplicate', [LinkController::class, 'duplicate'])->name('.links.duplicate');
    Route::post('/links/reorder', [LinkController::class, 'reorder'])->name('.links.reorder');
    
    // Social links
    Route::get('/social', [SocialLinkController::class, 'index'])->name('.social');
    Route::post('/social', [SocialLinkController::class, 'store'])->name('.social.store');
    Route::put('/social/{socialLink}', [SocialLinkController::class, 'update'])->name('.social.update');
    Route::delete('/social/{socialLink}', [SocialLinkController::class, 'destroy'])->name('.social.destroy');
    Route::post('/social/reorder', [SocialLinkController::class, 'reorder'])->name('.social.reorder');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('.analytics');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::post('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
    Route::post('/users/{user}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('audit-logs');
});

/*
|--------------------------------------------------------------------------
| Public Profile Routes (must be last - catches all usernames)
|--------------------------------------------------------------------------
*/
Route::get('/go/{link}', [PublicProfileController::class, 'trackClick'])->name('link.click');
Route::get('/{username}', [PublicProfileController::class, 'show'])->name('profile.show');
