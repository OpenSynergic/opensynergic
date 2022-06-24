<?php

namespace OpenSynergic\EventManagement\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OpenSynergic\EventManagement\EventManagement
 */
class EventManagement extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ems';
    }
}
