<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyDelivery {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        $token = $request->route('key');
        if ($token == null) {
            $token = $request->bearerToken();
        }
        if ($token == config('app.settings.delivery.key')) {
            return $next($request);
        }
        return response()->json([
            'error' => 'Invalid Key'
        ], 401);
    }
}
