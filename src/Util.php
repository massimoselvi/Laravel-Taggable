<?php

/*
 * This file is part of Laravel Taggable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Taggable;

use BrianFaust\Taggable\Interfaces\Taggable;

class Util
{
    public static function buildTagArray($tags)
    {
        if (is_array($tags)) {
            return $tags;
        }

        if (is_string($tags)) {
            $tags = preg_split('#['.preg_quote(
                config('taggable.delimiters', ','), '#'
            ).']#', $tags, null, PREG_SPLIT_NO_EMPTY);
        }

        return $tags;
    }

    public static function makeTagArray(Taggable $model, $field)
    {
        return $model->tags()->lists($field, 'tag_id');
    }

    public static function makeTagList(Taggable $model, $field)
    {
        return static::joinArray(
            static::makeTagArray($model, $field)->toArray()
        );
    }

    public static function joinArray(array $pieces)
    {
        return implode(
            substr(config('taggable.delimiters', ','), 0, 1), $pieces
        );
    }
}
