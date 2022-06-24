<?php

return [
  /**
   * Check if the application is already installed.
   */
  'installed' => env('APP_INSTALLED', false),

  /**
   * The path to the installation page.
   */
  'path' => 'install',

  /**
   * Installer Page.
   */
  'page' => [
    'title' => 'Wizard Installer',
    'class' => OpenSynergic\Installer\Livewire\InstallerPage::class
  ],

  'installing' => [
    /**
     * Actions to run when installing the application.
     */

    'actions' => [
      OpenSynergic\Installer\Pipe\Wizard\UpdateEnvData::class,
      OpenSynergic\Installer\Pipe\Wizard\CreateMySqlDatabase::class,
      OpenSynergic\Installer\Pipe\Wizard\MigrateDatabase::class,
      OpenSynergic\Installer\Pipe\Wizard\SeedDatabase::class,
    ],

    /**
     * Redirect to route name.
     */
    'redirect' => 'filament.pages.dashboard'
  ],

];
