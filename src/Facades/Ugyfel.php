<?php

namespace AlexGithub987\Ugyfel\Facades;

use Illuminate\Support\Facades\Facade;

class Ugyfel extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'ugyfel';
    }
}
