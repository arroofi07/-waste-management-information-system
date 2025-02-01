<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                if ($user->role === 'collector') {
                    return redirect()->route('collector.waste-reports.index');
                } elseif ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('home');
                }
            }
        }

        return $next($request);
    }
}
