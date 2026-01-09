<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use App\Services\AnalyticsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    /**
     * Admin dashboard
     */
    public function index(): View
    {
        $stats = $this->analyticsService->getPlatformAnalytics(30);
        $recentUsers = User::with('profile')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.index', compact('stats', 'recentUsers'));
    }

    /**
     * Users management
     */
    public function users(Request $request): View
    {
        $query = User::with('profile');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($q) use ($search) {
                        $q->where('username', 'like', "%{$search}%")
                            ->orWhere('display_name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'suspended') {
                $query->where('is_active', false);
            }
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * View user details
     */
    public function showUser(User $user): View
    {
        $user->load([
            'profile.links' => function ($q) {
                $q->select(['links.id','links.profile_id','links.title','links.url','links.icon','links.position','links.is_active'])
                  ->withCount('clicks')
                  ->orderBy('position');
            },
            'profile.socialLinks',
            'subscriptions.plan',
        ]);

        return view('admin.user-detail', compact('user'));
    }

    /**
     * Suspend user
     */
    public function suspendUser(Request $request, User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Cannot suspend admin users.']);
        }

        $user->update(['is_active' => false]);

        AuditLog::log(
            'user_suspended',
            $request->user(),
            $user,
            ['is_active' => true],
            ['is_active' => false],
            'User suspended by admin'
        );

        return back()->with('success', 'User has been suspended.');
    }

    /**
     * Activate user
     */
    public function activateUser(Request $request, User $user): RedirectResponse
    {
        $user->update(['is_active' => true]);

        AuditLog::log(
            'user_activated',
            $request->user(),
            $user,
            ['is_active' => false],
            ['is_active' => true],
            'User activated by admin'
        );

        return back()->with('success', 'User has been activated.');
    }

    /**
     * Platform analytics
     */
    public function analytics(Request $request): View
    {
        $days = $request->input('days', 30);
        $stats = $this->analyticsService->getPlatformAnalytics($days);

        return view('admin.analytics', compact('stats', 'days'));
    }

    /**
     * Audit logs
     */
    public function auditLogs(Request $request): View
    {
        $logs = AuditLog::with('user')
            ->latest('created_at')
            ->paginate(50);

        return view('admin.audit-logs', compact('logs'));
    }
}
