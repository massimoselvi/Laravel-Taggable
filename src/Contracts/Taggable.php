<?php

namespace BrianFaust\Taggable\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Taggable
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
