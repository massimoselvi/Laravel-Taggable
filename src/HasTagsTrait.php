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

use BrianFaust\Taggable\Exceptions\InvalidTagException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Stringy\StaticStringy as S;

trait HasTagsTrait
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }

    public function tag($tags)
    {
        $tags = Util::buildTagArray($tags);

        foreach ($tags as $tag) {
            $this->addOneTag($tag);
        }

        return $this;
    }

    public function untag($tags)
    {
        $tags = Util::buildTagArray($tags);

        foreach ($tags as $tag) {
            $this->removeOneTag($tag);
        }

        return $this;
    }

    public function retag($tags)
    {
        return $this->detag()->tag($tags);
    }

    public function detag()
    {
        $this->removeAllTags();

        return $this;
    }

    protected function addOneTag($string)
    {
        if ($this->onlyUseExistingTags) {
            $tag = Tag::findByName($string);

            if (empty($tag)) {
                throw new InvalidTagException("$string was not found in the list of tags.");
            }
        } else {
            $tag = Tag::findOrCreate($string);
        }

        if (! $this->tags instanceof Collection) {
            $this->tags = new Collection($this->tags);
        }

        if (! $this->tags->contains($tag->getKey())) {
            $this->tags()->attach($tag);
        }
    }

    protected function removeOneTag($string)
    {
        if ($tag = Tag::findByName($string)) {
            $this->tags()->detach($tag);
        }
    }

    protected function removeAllTags()
    {
        $this->tags()->sync([]);
    }

    public function getTagListAttribute()
    {
        return Util::makeTagList($this, 'name');
    }

    public function getTagListNormalizedAttribute()
    {
        return Util::makeTagList($this, 'slug');
    }

    public function getTagArrayAttribute()
    {
        return Util::makeTagArray($this, 'name');
    }

    public function getTagArrayNormalizedAttribute()
    {
        return Util::makeTagArray($this, 'slug');
    }

    public function scopeWithAllTags(Builder $query, $tags)
    {
        $tags = Util::buildTagArray($tags);
        $slug = array_map([S::class, 'slugify'], $tags);

        return $query->whereHas('tags', function ($q) use ($slug) {
            $q->whereIn('slug', $slug);
        }, '=', count($slug));
    }

    public function scopeWithAnyTags(Builder $query, $tags = [])
    {
        $tags = Util::buildTagArray($tags);

        if (empty($tags)) {
            return $query->has('tags');
        }

        $slug = array_map([S::class, 'slugify'], $tags);

        return $query->whereHas('tags', function ($q) use ($slug) {
            $q->whereIn('slug', $slug);
        });
    }

    public static function tagsArray()
    {
        return static::getAllTags(get_called_class());
    }

    public static function tagsList()
    {
        return Util::joinArray(static::getAllTags(get_called_class()));
    }

    public static function getAllTags($className)
    {
        return DB::table('taggables')->distinct()
            ->where('taggable_type', '=', $className)
            ->join('tags', 'taggables.tag_id', '=', 'tags.id')
            ->orderBy('tags.slug')
            ->lists('tags.slug');
    }
}
