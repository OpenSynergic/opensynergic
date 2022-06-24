<?php

namespace OpenSynergic\Core\Filament\Resources\UserResource\Pages;

use OpenSynergic\Core\Filament\Resources\UserResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Pages\Actions;


class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
