<?php

namespace BrianFaust\Taggable;

class ServiceProvider extends \BrianFaust\ServiceProvider\ServiceProvider
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
