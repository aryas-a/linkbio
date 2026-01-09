<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\AnalyticsService;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct(
        protected ProfileService $profileService,
        protected AnalyticsService $analyticsService
    ) {}

    /**
     * Show dashboard home
     */
    public function index(Request $request): View
    {
        $user = $request->user()->load('profile');
        $profile = $user->profile;
    
        if (!$profile) {
            return view('dashboard.create-profile');
        }
    
        $cacheKey = 'dashboard:' . $profile->id;
    
        $data = Cache::remember($cacheKey, 60, function () use ($profile) {
            return [
                'overview' => app(AnalyticsService::class)->getProfileOverview($profile, 30),
                'dailyViews' => app(AnalyticsService::class)->getDailyViews($profile, 7),
                'topLinks' => app(AnalyticsService::class)->getTopLinks($profile, 5, 30),
            ];
        });
    
        return view('dashboard.index', [
            'profile' => $profile,
            'overview' => $data['overview'],
            'dailyViews' => $data['dailyViews'],
            'topLinks' => $data['topLinks'],
        ]);
    }
    

    /**
     * Show profile settings
     */
    public function profile(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile;

        return view('dashboard.profile', compact('profile'));
    }

    /**
     * Update profile settings
     */
    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $profile = $request->user()->profile;
        
        $this->profileService->update($profile, $request->validated());

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload profile image
     */
    public function uploadProfileImage(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $profile = $request->user()->profile;
        $this->profileService->uploadProfileImage($profile, $request->file('profile_image'));

        return back()->with('success', 'Profile image updated!');
    }

    /**
     * Upload background image
     */
    public function uploadBackgroundImage(Request $request): RedirectResponse
    {
        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $profile = $request->user()->profile;
        $this->profileService->uploadBackgroundImage($profile, $request->file('background_image'));

        return back()->with('success', 'Background image updated!');
    }

    /**
     * Show appearance settings
     */
    public function appearance(Request $request): View
    {
        $profile = $request->user()->profile;

        return view('dashboard.appearance', compact('profile'));
    }

    /**
     * Update appearance settings
     */
    public function updateAppearance(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'background_type' => 'required|in:solid,gradient,image',
            'background_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'gradient_start' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'gradient_end' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'gradient_direction' => 'nullable|string|in:to-r,to-l,to-t,to-b,to-tr,to-tl,to-br,to-bl',
            'button_style' => 'required|in:rounded,pill,square,soft',
            'button_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_text_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'font_family' => 'required|string|max:50',
        ]);

        $profile = $request->user()->profile;
        $this->profileService->update($profile, $validated);

        return back()->with('success', 'Appearance updated!');
    }

    /**
     * Show SEO settings
     */
    public function seo(Request $request): View
    {
        $profile = $request->user()->profile;

        return view('dashboard.seo', compact('profile'));
    }

    /**
     * Update SEO settings
     */
    public function updateSeo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seo_title' => 'nullable|string|max:100',
            'seo_description' => 'nullable|string|max:300',
        ]);

        $profile = $request->user()->profile;
        $this->profileService->update($profile, $validated);

        return back()->with('success', 'SEO settings updated!');
    }

    /**
     * Upload OG image
     */
    public function uploadOgImage(Request $request): RedirectResponse
    {
        $request->validate([
            'og_image' => 'required|image|mimes:jpeg,png,jpg|max:2048|dimensions:min_width=1200,min_height=630',
        ]);

        $profile = $request->user()->profile;
        $this->profileService->uploadOgImage($profile, $request->file('og_image'));

        return back()->with('success', 'OG image updated!');
    }
}
