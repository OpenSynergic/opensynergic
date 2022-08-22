<?php

namespace OpenSynergic\ModelSettings;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModelSettingServiceProvider extends PackageServiceProvider
{

  public function configurePackage(Package $package): void
  {
    $package
      ->name('model-settings')
      ->hasMigration('create_model_settings_table')
      ->hasConfigFile('model-settings');
  }

  public function packageConfigured(Package $package): void
  {
  }

  public function packageRegistered(): void
  {
    parent::packageRegistered();
  }

  public function packageBooted(): void
  {
    parent::packageBooted();
  }
}
