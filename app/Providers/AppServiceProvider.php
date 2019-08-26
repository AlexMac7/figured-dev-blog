<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFromSubDirectories();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Retrieves the migrations folder sub directories and passes them to Laravel's loadMigrationsFrom method to be registered.
     *
     * https://stackoverflow.com/questions/21641606/laravel-running-migrations-on-app-database-migrations-folder-recursively
     *
     * @return void
     */
    protected function loadMigrationsFromSubDirectories()
    {
        $mainPath = database_path('migrations');
        $directories = glob($mainPath. '/mongodb', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }
}
