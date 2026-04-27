<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Session::get('is_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $userRole = $this->normalizeRole((string) Session::get('role_name', ''));
        $allowedRoles = array_map(fn ($role) => $this->normalizeRole((string) $role), $roles);

        if (!in_array($userRole, $allowedRoles, true)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }

    private function normalizeRole(string $role): string
    {
        return config('access.role_aliases.' . $role, $role);
    }
}