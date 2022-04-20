<?php

namespace IsotopeKit\AuthAPI\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class CheckIsAdmin
{
	public function handle($request, Closure $next)
	{
		$user = Auth::user();

		if ($user) {
			if ($user->isAdmin()) {
				return $next($request);
			}
		}
		
		return redirect('/');
		
	}
}