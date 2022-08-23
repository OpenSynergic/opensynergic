<?php

namespace OpenSynergic\ModelSettings\Model;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $type
 */
class ModelSetting extends Model
{
  protected $table = 'model_settings';

  public $timestamps = false;
}
