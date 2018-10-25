<?php

namespace ShawnRong\Avocado;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use ShawnRong\Avocado\Commands\InstallCommand;

class AvocadoServiceProvider extends ServiceProvider
{


    public function boot()
    {
        //Run install commands
        if ($this->app->runningInConsole()) {
            //register migrations
            $this->registerMigrations();
            //publish config file
            $this->publishes([
                __DIR__ . '/../config/avocado.php' => config_path('avocado.php'),
            ]);

            $this->commands([
                InstallCommand::class,
            ]);
            //Set up JWT Facade
            $this->app->register('Tymon\JWTAuth\Providers\LaravelServiceProvider');
            $loader = AliasLoader::getInstance();
            $loader->alias('JWTAuth', 'Tymon\JWTAuth\Facades\JWTAuth');
            $loader->alias('JWTFactory', 'Tymon\JWTAuth\Facades\JWTFactory');

            $this->publishes([
                __DIR__.'/../resources' => base_path('resources/js') . '/avocado'
            ]);

            $this->publishes([
                __DIR__.'/../views' => base_path('resources/views')
            ]);
        }
        //Set up routes/api.php
        $this->registerRouter();
    }

    /**
     * Register Database migrations
     */
    public function registerMigrations()
    {
        $migrationsPath = __DIR__ . '/../database/migrations/';

        $migrationFiles = [
            'create_admin_table.php',
            'add_custom_field_to_permission_table.php',
            'create_permission_groups_table.php',
        ];

        $paths = [];
        foreach ($migrationFiles as $key => $name) {
            $paths[$migrationsPath . $name] = database_path('migrations') . "/" . $this->formatTimestamp($key + 1) . '_' . $name;
        }
        $this->publishes($paths, 'migrations');
    }

    public function formatTimestamp($addition)
    {
        return date('Y_m_d_His', time() + $addition);
    }

    public function registerRouter()
    {
        if (!$this->app->routesAreCached()) {
            app('router')->middleware('api')->group(__DIR__ . '/routes.php');
        }
    }

    public function register()
    {

        $this->commands([
            InstallCommand::class,
        ]);
        //php artisan db:seed --class=AvocadoTableSeeder

        //更新 api.php
    }
}
