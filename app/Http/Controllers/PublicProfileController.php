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

        // Respect boolean-like env strings ("true", "false", "1", "0")
        $analyticsEnabled = filter_var(env('ANALYTICS_RECORD', false), FILTER_VALIDATE_BOOLEAN);
        // Record view only when explicitly enabled; never block the page on failure
        if ($analyticsEnabled) {
            try {
                $this->analyticsService->recordProfileView(
                    $profile,
                    $request->ip(),
                    $request->userAgent(),
                    $request->header('referer')
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return view('profile.show', compact('profile'));
    }

    /**
     * Track link click and redirect
     */
    public function trackClick(Request $request, Link $link): RedirectResponse
    {
        // Record click only when explicitly enabled; never block redirect
        $analyticsEnabled = filter_var(env('ANALYTICS_RECORD', false), FILTER_VALIDATE_BOOLEAN);
        if ($analyticsEnabled) {
            try {
                $this->analyticsService->recordLinkClick(
                    $link,
                    $request->ip(),
                    $request->userAgent(),
                    $request->header('referer')
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return redirect()->away($link->url);
    }
}
