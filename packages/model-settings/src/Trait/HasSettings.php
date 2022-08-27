<?php

namespace OpenSynergic\ModelSettings\Trait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use ResourceBundle;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use OpenSynergic\ModelSettings\Model\ModelSetting;

trait HasSettings
{
  protected array $settingAttributes = [];

  protected array $settingAttributesOriginal = [];

  protected array $settingsKeys = [];

  protected bool $settingsLoaded = false;

  protected ?string $preferredLocale = null;

  public static function usingLocale(string $locale)
  {
    return (new static())->setPreferredLocale($locale);
  }

  public function settings()
  {
    return $this->morphMany(ModelSetting::class, 'model');
  }

  public function getTranslatableAttributes(): array
  {
    return $this->translatable ?? [];
  }

  public function isAttributeTranslatable($key): bool
  {
    return in_array($key, $this->getTranslatableAttributes());
  }

  public static function bootHasSettings()
  {
    static::saved(function ($model) {
      $model->saveSettings();
    });
  }

  protected function getModelType()
  {
    return $this::class;
  }

  public function loadSettings()
  {
    if ((!$this->relationLoaded('settings') || $this->settingsLoaded) && filled($this->settingAttributes)) {
      return;
    }

    $this->settingAttributes = $this->settingAttributesOriginal = $this->readSettingsData();
    $this->settingsLoaded = true;

    return $this;
  }

  public function appendSettingsAttribute()
  {
    $this->setAppends(array_keys($this->settingAttributes));
  }


  public function saveSettings()
  {
    if (!$this->settingsLoaded) {
      return;
    }
    if (config('model_settings.cache.enabled')) {
      Cache::forget($this->getCacheKey());
    }

    $this->writeSettingsData();

    $this->settingsLoaded = false;
  }

  protected function getCacheKey()
  {
    return config('model_settings.cache.key') . '_' . $this->getModelType() . '_' . $this->getKey();
  }

  protected function writeSettingsData()
  {
    $dirtySettings = $this->getDirtySettings();
    if (empty($dirtySettings)) {
      return;
    }

    $performQuery = function ($key, $value, $locale = null) {
      if ($value === null) {
        $this->deleteSetting($key);
      } else {
        $this->updateSetting($key, $value, $locale);
      }
    };

    foreach ($dirtySettings as $key => $value) {
      if ($this->isDataTranslatable($value)) {
        foreach ($value as $locale => $val) {
          $performQuery($key, $val, $locale);
        }
        continue;
      }

      $performQuery($key, $value);
    }
  }

  protected function deleteSetting($key)
  {
    $this->newSettingsQuery()->where([
      'key' => $key,
    ])->delete();
  }

  protected function updateSetting($key, $value, $locale = null)
  {
    $this->newSettingsQuery()->updateOrInsert([
      'model_type' => $this->getModelType(),
      'model_id' => $this->getKey(),
      'key' => $key,
      'locale' => $locale,
    ], [
      'value' => $this->valueToDatabase($value),
    ]);
  }

  protected function readSettingsData()
  {
    if (!$this->exists) {
      return [];
    }
    return $this->parseDataFromDatabase($this->settings->toArray());
  }

  public function getPreferredLocale()
  {
    return $this->preferredLocale;
  }

  public function setPreferredLocale($locale)
  {
    if (!$locale) return $this;

    if (!$this->isValidLocale($locale)) {
      throw new \InvalidArgumentException('Invalid locale : ' . $locale);
    }

    $this->preferredLocale = $locale;

    return $this;
  }

  protected function parseDataFromDatabase($data)
  {
    $results = [];
    foreach ($data as $row) {
      $row = (object) $row;
      $value = $this->valueFromDatabase($row->value, $row->type);
      if ($row->locale) {
        $results[$row->key][$row->locale] = $value;
      } else {
        $results[$row->key] = $value;
      }
    }
    return $results;
  }

  protected function valueFromDatabase($value, $type)
  {
    switch ($type) {
      case 'boolean':
        return boolval($value);
      case 'integer':
        return (int) $value;
      case 'float':
        return (float) $value;
      case 'array':
        return json_decode($value, true);
      case 'object':
        return json_decode($value);
      default:
        return $value;
    }
  }

  protected function valueToDatabase($value)
  {
    switch (gettype($value)) {
      case 'boolean':
        return boolval($value);
      case 'integer':
        return (int) $value;
      case 'float':
        return (float) $value;
      case 'array':
        return json_encode($value);
      case 'object':
        return json_encode($value);
      default:
        return $value;
    }
  }

  protected function isDataTranslatable($data): bool
  {
    if (!filled($data) || !is_array($data)) return false;

    return $this->isValidLocale(array_key_first($data));
  }

  protected function isValidLocale($locale): bool
  {
    $allLocales = ResourceBundle::getLocales('');
    return in_array($locale, $allLocales);
  }

  protected function newSettingsQuery()
  {
    return DB::table('model_settings')
      ->where('model_type', $this->getModelType())
      ->where('model_id', $this->getKey());
  }

  public function hasSetting($key, $locale = null)
  {
    return boolval($this->get($key, $locale));
  }

  public function getSettingWithoutLocale($key)
  {
    return Arr::get($this->settingAttributes, $key);
  }

  public function getSettingOriginalWithoutLocale($key)
  {
    return Arr::get($this->settingAttributesOriginal, $key);
  }

  public function getSetting($key = null, $locale = null, $default = null)
  {
    $this->loadSettings();

    if ($key == null) return $this->getSettingAttributes();

    $fallbackLocale = $locale ?: $this->getPreferredLocale() ?: app()->getLocale();

    $data = $this->getSettingWithoutLocale($key);

    if (!filled($data)) return $default;

    if ($this->isAttributeTranslatable($key) && $locale !== false) {
      return Arr::get($data, $fallbackLocale, $default);
    }

    return $data;
  }

  public function getSettingOriginal($key = null, $locale = null)
  {
    if ($key == null) return $this->getSettingAttributesOriginal();

    $fallbackLocale = $locale ?: $this->getPreferredLocale() ?: app()->getLocale();

    $data = $this->getSettingOriginalWithoutLocale($key);

    if (!filled($data)) return $data;

    if ($this->isAttributeTranslatable($key) && $locale !== false) {
      return Arr::get($data, $fallbackLocale);
    }

    return $data;
  }

  public function settingAttributesToArray()
  {
    $this->loadSettings();

    $attributes = $this->settingAttributes;
    foreach ($this->getTranslatableAttributes() as $attribute) {
      $attributes[$attribute] = $this->getSetting($attribute);
    }

    return $attributes;
  }

  public function getSettingAttributes(): array
  {
    return $this->settingAttributes;
  }

  public function getSettingAttributesOriginal(): array
  {
    return $this->settingAttributesOriginal;
  }

  public function getDirtySettings(): array
  {
    $dirty = [];

    foreach ($this->getSettingAttributes() as $key => $value) {
      if (!$this->originalSettingIsEquivalent($key)) {
        $dirty[$key] = $value;
      }
    }
    return $dirty;
  }

  public function setSetting($key, $value, $locale = null): Model
  {
    $this->loadSettings();

    $data = Arr::get($this->settingAttributes, $key, []);
    switch (true) {
      case $this->isAttributeTranslatable($key) && $this->isDataTranslatable($value):
        $data  = $value;
        break;
      case $this->isAttributeTranslatable($key):
        $locale ??= $this->getPreferredLocale() ?: app()->getLocale();
        $data[$locale] = $value;
        break;
      default:
        $data = $value;
        break;
    }

    $this->settingAttributes[$key] = $data;

    return $this;
  }

  public function originalSettingIsEquivalent($key, $locale = false)
  {
    $original = $this->getSettingOriginal($key, $locale);
    $current = $this->getSetting($key, $locale);
    return $original == $current;
  }

  /**
   * Set attributes for the model
   *
   * @param array $attributes
   *
   * @return void
   */
  public function setAttributes(array $attributes)
  {
    foreach ($attributes as $key => $value) {
      $this->$key = $value;
    }
  }

  /**
   * Model Override functions
   * -------------------------.
   */

  public function getAttribute($key)
  {
    // parent call first.
    if (($attr = parent::getAttribute($key)) !== null) {
      return $attr;
    }

    // If key is a relation name, then return parent value.
    // The reason for this is that it's possible that the relation does not exist and parent call returns null for that.
    if ($this->isRelation($key) && $this->relationLoaded($key)) {
      return $attr;
    }

    // there was no attribute on the model
    // retrieve the data from setting
    $setting = $this->getSetting($key);

    // Check for meta accessor
    $accessor = Str::camel('get_' . $key . '_setting');

    if (method_exists($this, $accessor)) {
      return $this->{$accessor}($setting);
    }

    return $setting;
  }


  public function setAttribute($key, $value)
  {
    // First we will check for the presence of a mutator
    // or if key is a model attribute or has a column named to the key
    if (
      $this->hasSetMutator($key) ||
      $this->hasAttributeSetMutator($key) ||
      $this->isEnumCastable($key) ||
      $this->isClassCastable($key) ||
      (!is_null($value) && $this->isJsonCastable($key)) ||
      str_contains($key, '->') ||
      $this->hasColumn($key) ||
      array_key_exists($key, parent::getAttributes())
    ) {
      return parent::setAttribute($key, $value);
    }

    $mutator = Str::camel('set_' . $key . '_setting');

    if (method_exists($this, $mutator)) {
      return $this->{$mutator}($value);
    }

    return $this->setSetting($key, $value);
  }

  /**
   * Determine if model table has a given column.
   *
   * @param  [string]  $column
   *
   * @return boolean
   */
  public function hasColumn($column): bool
  {
    static $columns;
    $class = get_class($this);
    if (!isset($columns[$class])) {
      $columns[$class] = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
      if (empty($columns[$class])) {
        $columns[$class] = [];
      }
      $columns[$class] = array_map(
        'strtolower',
        $columns[$class]
      );
    }

    return in_array(strtolower($column), $columns[$class]);
  }
}
