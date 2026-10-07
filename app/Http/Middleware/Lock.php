<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Lock {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if (!config('app.settings.lock.enable') || config('app.settings.lock.password') == session('password')) {
            return $next($request);
        }
        return response()->view('frontend.lock');
    }
}
