<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetRlsSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // In web requests, set session-local variables for RLS policies
        $user = Auth::user();
        $userId = $user?->id;
        $role = ($user?->role === 'admin') ? 'admin' : ($user ? 'user' : 'anon');

        // Set LOCAL so it resets automatically at end of transaction/request
        // Use try/catch to avoid failing the request if not connected to Postgres
        try {
            if ($userId) {
                DB::statement('set local app.user_id = ?', [$userId]);
                DB::statement('set local app.role = ?', [$role]);
            } else {
                // Anonymous/public requests: clear user and set role to anon
                DB::statement('reset app.user_id');
                DB::statement("set local app.role = 'anon'");
            }
        } catch (\Throwable $e) {
            // Silently ignore in case of non-PgSQL connections during tests/cli
        }

        return $next($request);
    }
}
