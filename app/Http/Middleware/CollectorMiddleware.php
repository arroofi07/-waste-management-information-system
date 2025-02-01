<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CollectorMiddleware
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (!$request->user() || $request->user()->role !== 'collector') {
      abort(403);
    }

    return $next($request);
  }
}
