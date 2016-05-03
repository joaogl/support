<?php namespace jlourenco\support\Traits;

trait Sluggable {

    /**
     * Find a model by slug.
     *
     * @param $slug
     * @param array  $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function findBySlug($slug, array $columns = ['*'])
    {
        return self::whereSlug($slug)->first($columns);
    }

    /**
     * Find a model by slug or fail.
     *
     * @param $slug
     * @param array  $columns
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function findBySlugOrFail($slug, array $columns = ['*'])
    {
        return self::whereSlug($slug)->firstOrFail($columns);
    }

}