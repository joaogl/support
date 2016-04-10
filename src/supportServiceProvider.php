<?php namespace jlourenco\support;

use Illuminate\Support\ServiceProvider;
use jlourenco\support\Commands\SetupCommand;

class supportServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_DEBUG')) {
            ini_set('opcache.revalidate_freq', '0');
            ini_set('opcache.fast_shutdown', '0');
        }

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->prepareResources();
        $this->registerCommands();
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        // Publish a config file
        $this->publishes([
            __DIR__ . '/config' => base_path('/config')
        ], 'config');
    }

    /**
     * Register the commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->registerSetupCommand();
    }

    /**
     * Register the 'jlourenco:setup' command.
     *
     * @return void
     */
    protected function registerSetupCommand()
    {
        $this->app->singleton('command.jlourenco:setup', function() {
            return new SetupCommand();
        });
        $this->commands('command.jlourenco:setup');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.jlourenco:setup'
        ];
    }

}