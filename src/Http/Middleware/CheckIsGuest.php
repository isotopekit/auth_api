<?php

namespace IsotopeKit\AuthAPI\Http\Middleware;

use App;
// use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class CheckIsGuest
{
	public function handle($request, Closure $next, ...$guards)
	{
		$guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
		
	}
}