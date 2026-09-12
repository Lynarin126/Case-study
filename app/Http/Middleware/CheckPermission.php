<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string ...$parameters): Response
    {
        $user = $request->user();
        $logic = 'or';

        if (in_array(strtolower(end($parameters) ?: ''), ['and', 'or'], true)) {
            $logic = strtolower(array_pop($parameters));
        }

        $permissionList = array_values(array_filter(array_map('trim', $parameters)));

        $allowed = $user && (
            strtolower($logic) === 'and'
                ? $user->hasAllPermissions($permissionList)
                : $user->hasAnyPermission($permissionList)
        );

        abort_if(! $allowed, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
