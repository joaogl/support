<?php namespace jlourenco\support\Facades;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade
{

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'setting';
    }

}
