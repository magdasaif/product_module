<?php

namespace Modules\Product\Providers;

use Illuminate\Support\Facades\Route;
// use Modules\Product\Traits\Configuration;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    // use Configuration;
    //===================================================================================
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Product\Http\Controllers';
    //===================================================================================
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }
    //===================================================================================
    /**
     * Define the routes for the application.
     */
    public function map(): void{
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }
    //===================================================================================
    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void{
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            // ->group($this->module_path('Product', '/routes/web.php'));
            ->group( dirname(__DIR__).'/../routes/web.php');

        // Route::middleware('web')->group($this->module_path2('Product', '/routes/web.php'));
    }
    //===================================================================================
    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void{
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            // ->group($this->module_path('Product', '/routes/api.php'));
            ->group( dirname(__DIR__).'/../routes/api.php');

        // Route::middleware('api')->prefix('api')->name('api.')->group($this->module_path2('Product', '/routes/api.php'));
    }
    //===================================================================================
}
