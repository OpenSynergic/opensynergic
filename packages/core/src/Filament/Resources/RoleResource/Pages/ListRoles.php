<?php

namespace OpenSynergic\Core\Filament\Resources\RoleResource\Pages;

use OpenSynergic\Core\Filament\Resources\RoleResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    // protected function getActions(): array
    // {
    //     return array_merge([
    //         ButtonAction::make('setting')
    //             ->label(__('filament-shield::filament-shield.page.name'))
    //             ->url(static::$resource::getUrl('settings'))
    //             ->icon(__('filament-shield::filament-shield.page.icon'))
    //             ->color('primary')
    //             ->outlined()
    //     ], parent::getActions());
    // }
}
