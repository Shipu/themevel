<?php

namespace Shipu\Themevel\Providers;

use App;
use File;
use Illuminate\Support\ServiceProvider;
use Shipu\Themevel\Contracts\ThemeContract;
use Shipu\Themevel\Managers\Theme;

class ThemevelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!File::exists(public_path('Themes')) && config('theme.symlink') && File::exists(config('theme.theme_path'))) {
            App::make('files')->link(config('theme.theme_path'), public_path('Themes'));
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishConfig();
        $this->registerTheme();
        $this->registerHelper();
        $this->consoleCommand();
        $this->loadViewsFrom(__DIR__.'/../Views', 'themevel');
    }

    /**
     * Register theme required components .
     *
     * @return void
     */
    public function registerTheme()
    {
        $this->app->singleton(ThemeContract::class, function ($app) {
            $theme = new Theme($app, $this->app['view']->getFinder(), $this->app['config'], $this->app['translator']);

            return $theme;
        });
    }

    /**
     * Register All Helpers.
     *
     * @return void
     */
    public function registerHelper()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Publish config file.
     *
     * @return void
     */
    public function publishConfig()
    {
        $configPath = realpath(__DIR__.'/../../config/theme.php');

        $this->publishes([
            $configPath => config_path('theme.php'),
        ]);

        $this->mergeConfigFrom($configPath, 'themevel');
    }

    /**
     * Add Commands.
     *
     * @return void
     */
    public function consoleCommand()
    {
        $this->registerThemeGenerator();
        // Assign commands.
        $this->commands(
            'theme.create'
        );
    }

    /**
     * Register generator of theme.
     *
     * @return void
     */
    public function registerThemeGenerator()
    {
        $this->app->singleton('theme.create', function ($app) {
            return new \Shipu\Themevel\Console\ThemeGeneratorCommand($app['config'], $app['files']);
        });
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
