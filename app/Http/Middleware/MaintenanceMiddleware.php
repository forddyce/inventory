<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Original;

class MaintenanceMiddleware extends Original {
    protected $excludedIPs = [];

    protected function shouldPassThrough($request) {
        $adminUrl = config('app.adminUrl');
        $excepts = [$adminUrl, $adminUrl . '/*'];
        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($request->is($except)) {
                return true;
            }
        }
        return false;
    }

    public function handle($request, Closure $next) {
        if ($this->app->isDownForMaintenance()) {
            $response = $next($request);
            // if (in_array($request->ip(), $this->excludedIPs)) {
            //     return $response;
            // }
            $route = $request->route();
            if ($this->shouldPassThrough($request)) {
                return $response;
            }
            throw new HttpException(503);
        }
        return $next($request);
    }
}