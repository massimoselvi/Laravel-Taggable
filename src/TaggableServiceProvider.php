<?php

/*
 * This file is part of Laravel Taggable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/*
 * This file is part of Laravel Taggable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Taggable;

use BrianFaust\ServiceProvider\AbstractServiceProvider;

class TaggableServiceProvider extends AbstractServiceProvider
{
    public function boot(): void
    {
        $this->publishMigrations();

        $this->publishConfig();
    }

    public function register(): void
    {
        parent::register();

        $this->mergeConfig();
    }

    public function getPackageName(): string
    {
        return 'taggable';
    }
}
