<?php namespace jlourenco\support\Traits;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

trait Creation {

    /**
     * Boot the creation trait for a model.
     *
     * @return void
     */
    public static function bootCreation()
    {

        // create a event to happen on updating
        static::updating(function($table)  {
            $table->modified_by = Sentinel::getUser()->id;
        });

        // create a event to happen on deleting
        static::deleting(function($table)  {
            $table->deleted_by = Sentinel::getUser()->id;
        });

        // create a event to happen on saving
        static::saving(function($table)  {

            if ($user = Sentinel::check())
                $table->created_by = Sentinel::getUser()->id;

        });

    }

}