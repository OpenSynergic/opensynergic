<?php

namespace OpenSynergic\EventManagement;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use OpenSynergic\EventManagement\Filament\Resources\EventResource;
use OpenSynergic\Plugins\PluginManager;

class EventManagementServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        EventResource::class
    ];

    public static string $name = 'event-management';

    public function packageBooted(): void
    {
        parent::packageBooted();

        $this->registerModelPolicies();
    }

    public function packageConfigured(Package $package): void
    {
        $package
            ->hasMigration('create_event_management_tables');
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();
    }

    public function registerModelPolicies(): void
    {
        // Gate::policy(Event::class, EventPolicy::class);
    }
}
