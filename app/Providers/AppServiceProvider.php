<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route as RouteFacade;

use App\Http\Middleware\CheckRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register role middleware alias so routes can use 'role:admin'
        if ($this->app->runningInConsole() === false) {
            $router = $this->app['router'];
            if (method_exists($router, 'aliasMiddleware')) {
                $router->aliasMiddleware('role', CheckRole::class);
            }
        }
    }
}
