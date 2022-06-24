<?php

namespace OpenSynergic\EventManagement\Filament\Resources\EventResource\Pages;

use OpenSynergic\EventManagement\Filament\Resources\EventResource;
use Filament\Resources\Pages\ViewRecord;

class ViewEvent extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = EventResource::class;

    public function mount($record): void
    {
        parent::mount($record);
    }
}
