<?php

namespace OpenSynergic\Core\Filament\Resources\UserResource\Pages;

use OpenSynergic\Core\Filament\Resources\UserResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ManageUsers extends ManageRecords
{
    use Translatable;

    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
