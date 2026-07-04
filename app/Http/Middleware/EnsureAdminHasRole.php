<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminHasRole
{
    /**
     * Usage in routes: ->middleware('admin.role:Super Admin,Menu Manager')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $admin = auth('admin')->user();

        if (! $admin || ! $admin->is_active) {
            return redirect()->route('admin.login');
        }

        if (! empty($roles) && ! $admin->hasAnyRole($roles)) {
            abort(403, 'You do not have access to this section.');
        }

        return $next($request);
    }
}
