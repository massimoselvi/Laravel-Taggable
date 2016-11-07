<?php

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
