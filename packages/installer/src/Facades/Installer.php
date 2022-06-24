<?php

namespace OpenSynergic\Installer\Facades;

use Illuminate\Support\Facades\Facade;
use OpenSynergic\Installer\InstallerManager;

/**
 * @see \OpenSynergic\Installer\InstallerManager
 */
class Installer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return InstallerManager::class;
    }
}
