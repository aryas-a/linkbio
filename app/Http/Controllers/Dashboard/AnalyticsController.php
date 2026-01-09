<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    /**
     * Show analytics dashboard
     */
    public function index(Request $request): View
    {
        $profile = $request->user()->profile;
        $days = $request->input('days', 30);

        $overview = $this->analyticsService->getProfileOverview($profile, $days);
        $dailyViews = $this->analyticsService->getDailyViews($profile, $days);
        $dailyClicks = $this->analyticsService->getDailyClicks($profile, $days);
        $topLinks = $this->analyticsService->getTopLinks($profile, 10, $days);
        $deviceBreakdown = $this->analyticsService->getDeviceBreakdown($profile, $days);
        $browserBreakdown = $this->analyticsService->getBrowserBreakdown($profile, $days);
        $referrerBreakdown = $this->analyticsService->getReferrerBreakdown($profile, $days);

        return view('dashboard.analytics', compact(
            'profile',
            'days',
            'overview',
            'dailyViews',
            'dailyClicks',
            'topLinks',
            'deviceBreakdown',
            'browserBreakdown',
            'referrerBreakdown'
        ));
    }
}
