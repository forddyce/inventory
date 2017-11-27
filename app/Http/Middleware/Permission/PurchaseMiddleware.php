<?php

namespace App\Http\Middleware\Permission;

use Closure;

class PurchaseMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (!\Sentinel::check()) {
            return redirect()->route('login')->with('flashMessage', [
                'class'  =>  'warning',
                'message'   =>  'Login terlebih dahulu.'
            ]);
        }
        $user = \Sentinel::getUser();
        $permissions = $user->permissions;
        if (!isset($permissions['admin.purchase'])) {
            \Sentinel::logout($user);
            return redirect()->route('login')->with('flashMessage', [
                'class'  =>  'warning',
                'message'   =>  'Login terlebih dahulu.'
            ]);
        }
        if ($permissions['admin.purchase'] != 1) {
            \Sentinel::logout($user);
            return redirect()->route('login')->with('flashMessage', [
                'class'  =>  'warning',
                'message'   =>  'Login terlebih dahulu.'
            ]);
        }
        return $next($request);
    }
}
