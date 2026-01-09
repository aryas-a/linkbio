<?php

namespace App\Services;

use App\Models\Link;
use App\Models\LinkClick;
use App\Models\Profile;
use App\Models\ProfileView;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Record a profile view
     */
    public function recordProfileView(
        Profile $profile,
        string $ip,
        ?string $userAgent = null,
        ?string $referrer = null
    ): ProfileView {
        return ProfileView::recordView($profile, $ip, $userAgent, $referrer);
    }

    /**
     * Record a link click
     */
    public function recordLinkClick(
        Link $link,
        string $ip,
        ?string $userAgent = null,
        ?string $referrer = null
    ): LinkClick {
        return LinkClick::recordClick($link, $ip, $userAgent, $referrer);
    }

    /**
     * Get profile analytics overview
     */
    public function getProfileOverview(Profile $profile, int $days = 30): array
    {
        $cacheKey = "analytics:profile:{$profile->id}:overview:{$days}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($profile, $days) {
            $startDate = now()->subDays($days);

            return [
                'total_views' => $profile->views()->count(),
                'total_clicks' => $this->getTotalClicks($profile),
                'views_period' => $profile->views()
                    ->where('viewed_at', '>=', $startDate)
                    ->count(),
                'clicks_period' => $this->getClicksInPeriod($profile, $startDate),
                'views_today' => $profile->views()
                    ->whereDate('viewed_at', today())
                    ->count(),
                'clicks_today' => $this->getClicksToday($profile),
                'ctr' => $this->calculateCTR($profile, $days),
            ];
        });
    }

    /**
     * Get daily views for a profile
     */
    public function getDailyViews(Profile $profile, int $days = 30): Collection
    {
        $cacheKey = "analytics:profile:{$profile->id}:daily_views:{$days}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($profile, $days) {
            $startDate = now()->subDays($days)->startOfDay();

            $views = $profile->views()
                ->select(DB::raw('DATE(viewed_at) as date'), DB::raw('COUNT(*) as count'))
                ->where('viewed_at', '>=', $startDate)
                ->groupBy(DB::raw('DATE(viewed_at)'))
                ->orderBy('date')
                ->get()
                ->keyBy('date');

            // Fill in missing dates with 0
            $result = collect();
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $result->push([
                    'date' => $date,
                    'count' => $views->get($date)?->count ?? 0,
                ]);
            }

            return $result;
        });
    }

    /**
     * Get daily clicks for a profile
     */
    public function getDailyClicks(Profile $profile, int $days = 30): Collection
    {
        $cacheKey = "analytics:profile:{$profile->id}:daily_clicks:{$days}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($profile, $days) {
            $startDate = now()->subDays($days)->startOfDay();

            $linkIds = $profile->links()->pluck('id');

            $clicks = LinkClick::whereIn('link_id', $linkIds)
                ->select(DB::raw('DATE(clicked_at) as date'), DB::raw('COUNT(*) as count'))
                ->where('clicked_at', '>=', $startDate)
                ->groupBy(DB::raw('DATE(clicked_at)'))
                ->orderBy('date')
                ->get()
                ->keyBy('date');

            // Fill in missing dates with 0
            $result = collect();
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $result->push([
                    'date' => $date,
                    'count' => $clicks->get($date)?->count ?? 0,
                ]);
            }

            return $result;
        });
    }

    /**
     * Get top links by clicks
     */
    public function getTopLinks(Profile $profile, int $limit = 5, int $days = 30): Collection
    {
        $cacheKey = "analytics:profile:{$profile->id}:top_links:{$limit}:{$days}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($profile, $limit, $days) {
            $startDate = now()->subDays($days);

            return $profile->links()
                ->select(['links.id','links.profile_id','links.title','links.url','links.icon','links.position','links.is_active'])
                ->withCount(['clicks' => function ($query) use ($startDate) {
                    $query->where('clicked_at', '>=', $startDate);
                }])
                ->orderByDesc('clicks_count')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get device breakdown
     */
    public function getDeviceBreakdown(Profile $profile, int $days = 30): Collection
    {
        $cacheKey = "analytics:profile:{$profile->id}:device_breakdown:{$days}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($profile, $days) {
            $startDate = now()->subDays($days);

            return $profile->views()
                ->select('device_type', DB::raw('COUNT(*) as count'))
                ->where('viewed_at', '>=', $startDate)
                ->whereNotNull('device_type')
                ->groupBy('device_type')
                ->orderByDesc('count')
                ->get()
                ->map(function ($item) {
                    return [
                        'device' => $item->device_type,
                        'count' => $item->count,
                    ];
                });
        });
    }

    /**
     * Get browser breakdown
     */
    public function getBrowserBreakdown(Profile $profile, int $days = 30): Collection
    {
        $cacheKey = "analytics:profile:{$profile->id}:browser_breakdown:{$days}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($profile, $days) {
            $startDate = now()->subDays($days);

            return $profile->views()
                ->select('browser', DB::raw('COUNT(*) as count'))
                ->where('viewed_at', '>=', $startDate)
                ->whereNotNull('browser')
                ->groupBy('browser')
                ->orderByDesc('count')
                ->get()
                ->map(function ($item) {
                    return [
                        'browser' => $item->browser,
                        'count' => $item->count,
                    ];
                });
        });
    }

    /**
     * Get referrer breakdown
     */
    public function getReferrerBreakdown(Profile $profile, int $days = 30, int $limit = 10): Collection
    {
        $cacheKey = "analytics:profile:{$profile->id}:referrer_breakdown:{$days}:{$limit}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($profile, $days, $limit) {
            $startDate = now()->subDays($days);

            return $profile->views()
                ->select('referrer', DB::raw('COUNT(*) as count'))
                ->where('viewed_at', '>=', $startDate)
                ->whereNotNull('referrer')
                ->where('referrer', '!=', '')
                ->groupBy('referrer')
                ->orderByDesc('count')
                ->limit($limit)
                ->get()
                ->map(function ($item) {
                    $referrer = $item->referrer;
                    $domain = parse_url($referrer, PHP_URL_HOST) ?? $referrer;
                    
                    return [
                        'referrer' => $domain,
                        'full_url' => $referrer,
                        'count' => $item->count,
                    ];
                });
        });
    }

    /**
     * Get platform analytics (admin)
     */
    public function getPlatformAnalytics(int $days = 30): array
    {
        $cacheKey = "analytics:platform:overview:{$days}";
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($days) {
            $startDate = now()->subDays($days);

            return [
                'total_profiles' => Profile::count(),
                'total_links' => Link::count(),
                'total_views' => ProfileView::count(),
                'total_clicks' => LinkClick::count(),
                'new_profiles' => Profile::where('created_at', '>=', $startDate)->count(),
                'views_period' => ProfileView::where('viewed_at', '>=', $startDate)->count(),
                'clicks_period' => LinkClick::where('clicked_at', '>=', $startDate)->count(),
            ];
        });
    }

    /**
     * Helper methods
     */
    protected function getTotalClicks(Profile $profile): int
    {
        return LinkClick::whereIn('link_id', $profile->links()->pluck('id'))->count();
    }

    protected function getClicksInPeriod(Profile $profile, Carbon $startDate): int
    {
        return LinkClick::whereIn('link_id', $profile->links()->pluck('id'))
            ->where('clicked_at', '>=', $startDate)
            ->count();
    }

    protected function getClicksToday(Profile $profile): int
    {
        return LinkClick::whereIn('link_id', $profile->links()->pluck('id'))
            ->whereDate('clicked_at', today())
            ->count();
    }

    protected function calculateCTR(Profile $profile, int $days): float
    {
        $startDate = now()->subDays($days);
        
        $views = $profile->views()->where('viewed_at', '>=', $startDate)->count();
        $clicks = $this->getClicksInPeriod($profile, $startDate);

        if ($views === 0) {
            return 0;
        }

        return round(($clicks / $views) * 100, 2);
    }
}
