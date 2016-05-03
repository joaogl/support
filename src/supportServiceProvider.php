<?php namespace jlourenco\support;

use Illuminate\Support\ServiceProvider;
use jlourenco\support\Interfaces\LaravelFallbackInterface;
use jlourenco\support\Commands\ConfigCommand;
use jlourenco\support\Commands\MigrateCommand;

class supportServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

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
        $this->registerToAppConfig();
        $this->registerSetting();
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
        $this->registerConfigCommand();
        $this->registerMigrationCommand();
    }

    /**
     * Register the 'jlourenco:setup' command.
     *
     * @return void
     */
    protected function registerConfigCommand()
    {
        $this->app->singleton('command.jlourenco:config', function() {
            return new ConfigCommand();
        });
        $this->commands('command.jlourenco:config');
    }

    /**
     * Register the 'jlourenco:migrate' command.
     *
     * @return void
     */
    protected function registerMigrationCommand()
    {
        $this->app->singleton('command.jlourenco:migrate', function() {
            return new MigrateCommand();
        });
        $this->commands('command.jlourenco:migrate');
    }

    /**
     * Registers this module to the
     * services providers and aliases.
     *
     * @return void
     */
    protected function registerToAppConfig()
    {
        /*
         * Register the service provider for the dependencies.
         */
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // $this->app->register('jlourenco\support\supportServiceProvider');

        /*
         * Create aliases for the dependencies.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Input', 'Illuminate\Support\Facades\Input');
        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('Html', 'Collective\Html\HtmlFacade');
        $loader->alias('Setting', 'jlourenco\support\Facades\Setting');
    }

    /**
     * Registers setting.
     *
     * @return void
     */
    protected function registerSetting()
    {
        $this->app->singleton('setting', function ($app) {
            $config = $app['config']->get('jlourenco.support');

            $path = array_get($config, 'Setting.path');
            $filename = array_get($config, 'Setting.filename');
            $fallback = array_get($config, 'Setting.fallback') ? new LaravelFallbackInterface() : null;

            $set = new Setting($path, $filename, $fallback);

            return $set;
        });

        $config = $this->app['config']->get('jlourenco.support');

        if (array_get($config, 'Setting.autoAlias'))
            $this->app->alias('setting', 'jlourenco\support\Setting');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.jlourenco:config',
            'command.jlourenco:migrate',
            'Setting'
        ];
    }

}