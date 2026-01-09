<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Profile;
use App\Services\AnalyticsService;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    public function __construct(
        protected ProfileService $profileService,
        protected AnalyticsService $analyticsService
    ) {}

    /**
     * Show public profile page
     */
    public function show(Request $request, string $username): View|RedirectResponse
    {
        $profile = $this->profileService->getByUsername($username);

        if (!$profile) {
            abort(404);
        }

        // Record view in production or when explicitly enabled for dev via ANALYTICS_RECORD=true
        if (app()->environment('production') || (bool) env('ANALYTICS_RECORD', false)) {
            $this->analyticsService->recordProfileView(
                $profile,
                $request->ip(),
                $request->userAgent(),
                $request->header('referer')
            );
        }

        return view('profile.show', compact('profile'));
    }

    /**
     * Track link click and redirect
     */
    public function trackClick(Request $request, Link $link): RedirectResponse
    {
        // Record click in production or when explicitly enabled for dev via ANALYTICS_RECORD=true
        if (app()->environment('production') || (bool) env('ANALYTICS_RECORD', false)) {
            $this->analyticsService->recordLinkClick(
                $link,
                $request->ip(),
                $request->userAgent(),
                $request->header('referer')
            );
        }

        return redirect()->away($link->url);
    }
}
