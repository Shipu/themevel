<?php

namespace Shipu\Themevel\Providers;

use Illuminate\Support\ServiceProvider;
use Shipu\Themevel\Contracts\ThemeContract;
use Shipu\Themevel\Managers\Theme;
use View, File, App;

class ThemevelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!File::exists(public_path('Themes')) && config('theme.symlink')) {
            App::make('files')->link(config('theme.paths.themes'), public_path('Themes'));
        }
        
        $configPath = __DIR__.'/../../config/theme.php';
        
        $this->publishes([
            $configPath => config_path('theme.php')
        ]);
        
        $this->mergeConfigFrom($configPath, 'themevel');
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTheme();
        $this->registerHelper();
        $this->loadViewsFrom(__DIR__ . '/../Views', 'themevel');
    }
    
    /**
     * Register theme required components .
     *
     * @return void
     */
    public function registerTheme()
    {
        $this->app->singleton(ThemeContract::class, function($app){
            $theme = new Theme($app, $this->app['view']->getFinder());
            return $theme;
        });
        \Theme::set(config('theme.active'));
    }
    
    /**
     * Register All Helpers
     *
     * @return void
     */
    public function registerHelper()
    {
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename){
            require_once($filename);
        }
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
