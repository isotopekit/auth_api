<?php

namespace IsotopeKit\AuthAPI;

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Container\Container;

use Illuminate\Routing\Router;

// custom middlewares
use IsotopeKit\AuthAPI\Http\Middleware\CheckIsUser;
use IsotopeKit\AuthAPI\Http\Middleware\CheckIsAdmin;
use IsotopeKit\AuthAPI\Http\Middleware\CheckIsAgency;
use IsotopeKit\AuthAPI\Http\Middleware\CheckIsTeam;
use IsotopeKit\AuthAPI\Http\Middleware\CheckIsGuest;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	public function boot()
	{
		// views
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'authapi');

		// routes
		$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

		if ($this->app->runningInConsole()) {
			// export the migration

			if (!class_exists('CreateAuthTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/create_auth_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_auth_table.php'),
					// you can add any number of migrations here
				], 'migrations');
			}

			// publish config
			$this->publishes([
				__DIR__ . '/../config/config.php' => config_path('authapi.php'),
			], 'config');

			// publish views
			// $this->publishes([
			// 	__DIR__ . '/../resources/views' => resource_path('views/vendor/isotopekit'),
			// ], 'views');
		}

		// routes
		$router = $this->app->make(Router::class);

		// middleware groups
		
		// $router->aliasMiddleware('agency', CheckIsAgency::class);
		// $router->aliasMiddleware('team', CheckIsTeam::class);
		
		// guest
		$router->middlewareGroup('guest', array(
			\App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
			CheckIsGuest::class
		));


		// admin
		$router->middlewareGroup('admin', array(
			\App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
			CheckIsAdmin::class
		));

		// user
		$router->middlewareGroup('user', array(
			\App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
			CheckIsUser::class
		));


	}

	public function register()
	{
		// config
		$this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'authapi');
	}
}
