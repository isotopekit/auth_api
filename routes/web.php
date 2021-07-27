<?php

use Illuminate\Support\Facades\Route;
use IsotopeKit\AuthAPI\Http\Controllers\AuthController;

Route::group(
	[
		'prefix'		=>	config('isotopekit_auth.route_prefix'),
		'middleware'	=>	['guest']
	],
	function () {
		// Login Route
		// override this from saasKit (with your own view)
		Route::get('/login', [AuthController::class, 'getLogin'])->name('get_login_route');
		
		Route::post('/login', [AuthController::class, 'postLogin'])->name('post_login_route');
		
		// Register Route
		// override this from saasKit (with your own view)
		Route::get('/register', [AuthController::class, 'getRegister'])->name('get_register_route');
		
		Route::post('/register', [AuthController::class, 'postRegister'])->name('post_register_route');
	}
);

// test

// Route::group(
// 	[
// 		'prefix'		=>	'admin',
// 		'middleware'	=>	['admin']
// 	],
// 	function () {
// 		Route::get('/info', [AuthController::class, 'getInfo']);
// 		Route::get('/logout', [AuthController::class, 'postLogout']);
// 	}
// );

// Route::group(
// 	[
// 		'prefix'		=>	'user',
// 		'middleware'	=>	['user']
// 	],
// 	function () {
// 		Route::get('/info', [AuthController::class, 'getUserInfo']);
// 		Route::get('/logout', [AuthController::class, 'postLogout']);
// 	}
// );
