<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDepartmentPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

            $user = Auth::user();

            if (!$user || !$user->hasPermissionTo('view_department')) {
                // User does not have permission to view departments
                return redirect()->route('home')->with('error', 'Unauthorized access.');
            }

            return $next($request);

    }
}
