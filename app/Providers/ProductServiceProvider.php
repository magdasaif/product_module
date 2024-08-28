<?php

namespace Modules\Product\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
// use Modules\Product\Traits\Configuration;

class ProductServiceProvider extends ServiceProvider
{
    // use Configuration;
    //===================================================================================
    protected string $moduleName        = 'Product';
    protected string $moduleNameLower   = 'product';
    //===================================================================================
    /**
     * Boot the application events.
     */
    public function boot(): void{
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        // $this->loadMigrationsFrom($this->module_path($this->moduleName, 'database/migrations'));
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        // $this->overrideModuleFiles();
        //==============================================================================================
        // publish all package folder
        $this->publishes([
            dirname(__DIR__) .'/..' => base_path('Modules/',$this->moduleName)        
        ], 'product-module');
        //==============================================================================================
        // publish config
        $this->publishes([
            dirname(__DIR__) .'/../config/config.php' => config_path('product.php'),
        ], 'product-config');
        //==============================================================================================
    }
    //===================================================================================
    /**
     * Register the service provider.
     */
    public function register(): void{
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
    //===================================================================================
    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void{
        $this->commands([
            \Modules\Product\Console\PublishModuleCommand::class,
        ]);
    }
    //===================================================================================
    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void{
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }
    //===================================================================================
    /**
     * Register translations.
     */
    public function registerTranslations(): void{
        $langPath = resource_path('lang/modules/product');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'product');
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            // $this->loadTranslationsFrom($this->module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            // $this->loadJsonTranslationsFrom($this->module_path($this->moduleName, 'lang'));

            $this->loadTranslationsFrom(__DIR__.'/../../lang', 'product');
            $this->loadJsonTranslationsFrom(__DIR__.'/../../lang');
        }
    }
    //===================================================================================
    /**
     * Register config.
     */
    protected function registerConfig(): void{
        //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        // $this->publishes([$this->module_path($this->moduleName, 'config/config.php') => config_path('setting.php')], 'config');
        // $this->mergeConfigFrom($this->module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
        $this->publishes([__DIR__.'/../../config/config.php' => config_path('product.php')], 'config');
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'product');
        //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    }
    //===================================================================================
    /**
     * Register views.
     */
    public function registerViews(): void{
        $viewPath = resource_path('views/modules/product');
        // $sourcePath = $this->module_path($this->moduleName, 'resources/views');
        $sourcePath = __DIR__.'/../../resources/views';

        $this->publishes([$sourcePath => $viewPath], ['views', 'product-module-views']);
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), 'product');
        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.ltrim(config('modules.paths.generator.component-class.path'), config('modules.paths.app_folder', '')));
        Blade::componentNamespace($componentNamespace, 'product');
    }
    //===================================================================================
    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array {
        return [];
    }
    //===================================================================================
    /**
     * @return array<string>
     */
    private function getPublishableViewPaths(): array{
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/product')) {
                $paths[] = $path.'/modules/product';
            }
        }
        return $paths;
    }
    //===================================================================================
    // protected function overrideModuleFiles(){
    //     Log::info("============================================================");
    //     Log::info("inside overrideModuleFiles function line 139");
    //     $packagePath = __DIR__ . '/../../';
    //     $composerJson = json_decode(file_get_contents($packagePath . 'composer.json'), true);
    //     $filesToOverride = $composerJson['extra']['module-files'] ?? [];

    //     foreach ($filesToOverride as $originalFile => $overrideFile) {
    //         $originalPath = base_path('vendor/nwidart/laravel-modules/src/' . $originalFile);
    //         $overridePath = $packagePath . $overrideFile;

    //         if (file_exists($overridePath)) {
    //             copy($overridePath, $originalPath);
    //         }
    //     }
    //     Log::info("============================================================");
    // }
    //======================================================================
}
