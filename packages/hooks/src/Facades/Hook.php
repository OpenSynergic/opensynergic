<?php

namespace OpenSynergic\Hooks\Facades;

use Illuminate\Support\Facades\Facade;
use OpenSynergic\Hooks\HookManager;

/**
 * @see \OpenSynergic\Hooks\HookManager
 */
class Hook extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HookManager::class;
    }
}
