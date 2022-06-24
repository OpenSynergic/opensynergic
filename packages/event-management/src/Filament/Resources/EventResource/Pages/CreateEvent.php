<?php

namespace OpenSynergic\EventManagement\Filament\Resources\EventResource\Pages;

use OpenSynergic\EventManagement\Filament\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = EventResource::class;

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }
}
