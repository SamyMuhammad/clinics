<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsTestResponsible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isTestResponsible()) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
