<?php

namespace Vatlayer\Facade;

use Illuminate\Support\Facades\Facade;

class Vatlayer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'vatlayer';
    }
}
