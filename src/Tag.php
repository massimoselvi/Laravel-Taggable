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

use Illuminate\Database\Eloquent\Model as Eloquent;
use Stringy\StaticStringy as S;

class Tag extends Eloquent
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function taggable()
    {
        return $this->morphTo();
    }

    public function setNameAttribute($value)
    {
        $value = trim($value);
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = S::slugify($value);
    }

    public static function findOrCreate($name)
    {
        if (!$tag = static::findByName($name)) {
            $tag = static::create(compact('name'));
        }

        return $tag;
    }

    public static function findByName($name)
    {
        return static::where('slug', S::slugify($name))->first();
    }

    public function __toString()
    {
        return $this->getAttribute('name');
    }
}
