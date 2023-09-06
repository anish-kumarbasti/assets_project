<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // dd($request);
        // Check if the user has the specified permission
        if (Auth::check() && Auth::user()->can($permission)) {
            return $next($request);
        }

        return abort(403, 'Unauthorized.');
    }
}
