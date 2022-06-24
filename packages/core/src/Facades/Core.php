<?php

namespace OpenSynergic\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OpenSynergic\Core\Core
 */
class Core extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'core';
    }
}
