<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inject common dashboard user data to avoid N+1 in Blade
        View::composer([
            'components.layouts.dashboard',
            'layouts.dashboard',
        ], function ($view) {
            $authId = Auth::id();
            $user = $authId ? User::with('profile')->find($authId) : null;
            $profile = $user?->profile;
            $email = $user?->email;
            $view->with('authProfile', $profile)
                 ->with('authUserEmail', $email);
        });

        // Optional per-request DB query profiling
        if (env('PROFILE_DB', false)) {
            $min = (int) env('PROFILE_DB_MIN_MS', 100);
            DB::listen(function ($query) use ($min) {
                $time = (int) $query->time; // ms
                if ($time >= $min) {
                    Log::channel('stack')->info('sql_query', [
                        'time_ms' => $time,
                        'sql' => $query->sql,
                    ]);
                }
            });
        }
    }
}
