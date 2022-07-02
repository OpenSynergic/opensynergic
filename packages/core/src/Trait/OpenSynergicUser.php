<?php

namespace OpenSynergic\Core\Trait;

use Glorand\Model\Settings\Traits\HasSettingsTable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

trait OpenSynergicUser
{
    use InteractsWithMedia;
    use HasRoles;
    use HasSettingsTable;

    protected $metaTable = 'users_details';

    protected function getMetaObject($keys, $default = null)
    {
        return $this->getMetaArray($keys, $default);
    }
}
