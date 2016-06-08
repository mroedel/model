<?php

namespace Roedel\Model;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    protected $migrations = [
        'CreateRevisionsTable' => 'create_revisions_table.php',
    ];

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/roedel-model.php' => config_path('roedel-model.php'),
        ], 'config');

        $lastTimestamp = 0;
        foreach ($this->migrations as $class => $migration) {
            if (!class_exists($class)) {
                $currentTimestamp = date('Y_m_d_His', time());
                if ($currentTimestamp === $lastTimestamp) {
                    $currentTimestamp++;
                }

                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migration}.stub" => database_path("migrations/{$currentTimestamp}_{$migration}"),
                ], 'migrations');

                $lastTimestamp = $currentTimestamp;
            }
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/roedel-model.php', 'roedel-model'
        );
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
