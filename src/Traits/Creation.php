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

        // create a event to happen on deleting
        static::deleting(function($table)  {
            if (class_exists('Cartalyst\Sentinel\Laravel\Facades\Sentinel'))
                $table->deleted_by = Sentinel::getUser()->id;
            else
                $table->deleted_by = Auth::user()->id;

            $table->update(['deleted_by' => $table->deleted_by]);
        });

        // create a event to happen on saving
        static::saving(function($table)  {

            if (class_exists('Cartalyst\Sentinel\Laravel\Facades\Sentinel'))
            {
                if (Sentinel::check())
                    $table->modified_by = Sentinel::getUser()->id;

                if (Sentinel::check() && ($table->created_by == null || !($table->created_by > 0)))
                    $table->created_by = Sentinel::getUser()->id;
            }
            else
            {
                if (!Auth::guest())
                    $table->modified_by = Auth::user()->id;

                if (!Auth::guest() && ($table->created_by == null || !($table->created_by > 0)))
                    $table->created_by = Auth::user()->id;
            }

        });

    }

    public function deletedBy()
    {
        return Sentinel::createModel()->find($this->deleted_by);
    }
    
}