<?php

namespace OpenSynergic\Installer;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use OpenSynergic\Installer\Commands\InstallerCommand;
use OpenSynergic\Installer\Livewire\InstallerPage;

class InstallerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('installer')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasMigration('create_installer_table')
            ->hasCommand(InstallerCommand::class);
    }

    public function packageRegistered()
    {
        $installer = config('installer.page.class', InstallerPage::class);

        Livewire::component($installer::getName(), $installer);

        $this->app->singleton(InstallerManager::class, function (): InstallerManager {
            return new InstallerManager();
        });
    }
}
