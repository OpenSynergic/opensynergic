<?php

namespace OpenSynergic\Core;

use Filament\Forms\Components\TextInput;
use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use OpenSynergic\Core\Filament\Pages\Profile;
use Spatie\LaravelPackageTools\Package;
use OpenSynergic\Core\Filament\Pages\Settings\Access;
use OpenSynergic\Core\Livewire\Tables;
use OpenSynergic\Core\Filament\Resources\RoleResource;
use OpenSynergic\Core\Filament\Resources\UserResource;
use OpenSynergic\Hooks\Facades\Hook;
use Spatie\Permission\Models\Permission;

class CoreServiceProvider extends PluginServiceProvider
{
    public static string $name = 'core';

    protected array $livewireComponents = [
        Tables\Users::class,
        Tables\Roles::class,
    ];

    public function packageConfigured(Package $package): void
    {
        $package->hasMigration('create_core_table');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        $this->gateCallback();
        $this->bootLivewireComponents();
    }

    public function gateCallback()
    {
        if (config('core.permissions.auto_create')) {
            Gate::before(function ($user, $ability): void {
                if (in_array($ability, config('core.permissions.exclude'))) {
                    return;
                }

                $permission = Permission::getPermission(['name' => $ability]);
                if (!$permission) {
                    DB::transaction(function () use ($ability) {
                        Permission::create([
                            'name' => $ability,
                        ]);
                    });
                }
            });
        }


        if (config('core.super_admin.enabled')) {
            Gate::before(function ($user, $ability): ?bool {
                return $user?->hasRole(config('core.super_admin.name', 'super_admin')) ? true : null;
            });
        }
    }

    protected function bootLivewireComponents(): void
    {
        foreach ($this->livewireComponents as $class) {
            Livewire::component($class::getName(), $class);
        }
    }

    protected function getUserMenuItems(): array
    {
        return [
            UserMenuItem::make()
                ->label('Profile')
                ->url(route(Profile::getRouteName()))
                ->icon('heroicon-s-cog'),
        ];
    }

    protected function getPages(): array
    {
        return config('core.register.pages', $this->pages);
    }

    protected function getResources(): array
    {
        return config('core.register.resources', $this->resources);
    }

    protected function getBeforeCoreScripts(): array
    {
        return config('core.register.beforeCoreScripts', $this->beforeCoreScripts);
    }

    protected function getScripts(): array
    {
        return config('core.register.scripts', $this->scripts);
    }

    protected function getStyles(): array
    {
        return config('core.register.styles', $this->styles);
    }
}
