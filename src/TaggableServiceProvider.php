<?php

namespace BrianFaust\Taggable;

use BrianFaust\ServiceProvider\ServiceProvider;

class TaggableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishMigrations();

        $this->publishConfig();
    }

    public function register()
    {
        parent::register();

        $this->mergeConfig();
    }

    public function getPackageName()
    {
        return 'taggable';
    }
}
