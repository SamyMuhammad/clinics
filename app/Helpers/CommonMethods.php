<?php

namespace App\Helpers;

/**
 * Common Models Methods.
 */
trait CommonMethods
{
    public function getNameAttribute()
    {
        $attribute = app()->getLocale() === 'ar' ? 'ar_name' : 'en_name';
        return $this->$attribute;
    }
}
