<?php

namespace OpenSynergic\EventManagement\Filament\Resources\EventResource\Pages;

use OpenSynergic\EventManagement\Filament\Resources\EventResource;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = EventResource::class;
}
