<?php

namespace OpenSynergic\Core\Trait;

use Glorand\Model\Settings\Traits\HasSettingsTable;
use Kodeine\Metable\Metable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

trait OpenSynergicUser
{
  use InteractsWithMedia,
    HasRoles,
    Metable,
    HasSettingsTable;

  protected $metaTable = 'users_details';
}
