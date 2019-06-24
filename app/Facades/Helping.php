<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class Helping  extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'help';
    }
}