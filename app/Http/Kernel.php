<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		// \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\App\Http\Middleware\MaintenanceMiddleware::class
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			\App\Http\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\App\Http\Middleware\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
		],

		'api' => [
			\App\Http\Middleware\EncryptCookies::class,
			\Illuminate\Session\Middleware\StartSession::class,
			'throttle:60,1',
			'bindings',
		],
	];

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		// 'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
		// 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		// 'can' => \Illuminate\Auth\Middleware\Authorize::class,
		// 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'admin'			 =>	\App\Http\Middleware\Permission\AdminMiddleware::class,
		'admin.sales'	 =>	\App\Http\Middleware\Permission\SalesMiddleware::class,
		'admin.purchase' =>	\App\Http\Middleware\Permission\PurchaseMiddleware::class,
		'admin.expense'  =>	\App\Http\Middleware\Permission\ExpenseMiddleware::class,
		'admin.supplier' =>	\App\Http\Middleware\Permission\SupplierMiddleware::class,
		'admin.client'   =>	\App\Http\Middleware\Permission\ClientMiddleware::class,
		'admin.item' 	 =>	\App\Http\Middleware\Permission\ItemMiddleware::class,
		'admin.user' 	 =>	\App\Http\Middleware\Permission\UserMiddleware::class,
	];
}
