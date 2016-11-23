<?php

/*
 * This file is part of Laravel Taggable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Taggable\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface HasTags
{
    public function tags();

    public function tag($tags);

    public function untag($tags);

    public function retag($tags);

    public function detag();

    public function scopeWithAllTags(Builder $query, $tags);

    public function scopeWithAnyTags(Builder $query, $tags = []);

    public static function tagsArray();

    public static function tagsList();
}
