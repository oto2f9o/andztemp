<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class FetchSettings {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        $options = file_exists(storage_path('installed')) ? Setting::get() : [];
        $theme = session('theme', $request->query('theme'));
        if ($request->query('theme')) {
            $theme = $request->query('theme');
        }
        foreach ($options as $option) {
            config([
                'app.settings.' . $option->key => unserialize($option->value)
            ]);
        }
        if ($theme && is_dir(resource_path('views/themes/' . $theme))) {
            session(['theme' => $theme]);
            config(['app.settings.theme' => $theme]);
        }
        return $next($request);
    }
}
