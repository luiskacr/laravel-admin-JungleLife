<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @param mixed ...$roles
     * @return JsonResponse|RedirectResponse|Response
     */
    public function handle(Request $request, Closure $next, ...$roles): JsonResponse|RedirectResponse|Response
    {
        if ($request->ajax() or $request->wantsJson() or $request->header('Accept') === 'application/json') {
            if (is_array($roles)) {
                foreach ($roles as $role) {
                    if ($request->user()->hasRole($role)) {
                        return $next($request);
                    }
                }
            } else {
                if ($request->user()->hasRole($roles)) {
                    return $next($request);
                }
            }
            return new JsonResponse(['error' => 'No tienes permiso para acceder a esta página.'], 403);
        }
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($request->user()->hasRole($role)) {
                    return $next($request);
                }
            }
        } else {
            if ($request->user()->hasRole($roles)) {
                return $next($request);
            }
        }
        abort(403);
    }
}
