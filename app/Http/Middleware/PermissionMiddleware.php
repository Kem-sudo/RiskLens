<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!Session::get('is_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $role = $this->normalizeRole((string) Session::get('role_name', ''));
        $permissions = config('access.permissions.' . $role, []);

        if (!in_array($permission, $permissions, true)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }

    private function normalizeRole(string $role): string
    {
        return config('access.role_aliases.' . $role, $role);
    }
}
