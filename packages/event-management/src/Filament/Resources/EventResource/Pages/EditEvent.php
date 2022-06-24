<?php

namespace OpenSynergic\EventManagement\Filament\Resources\EventResource\Pages;

use OpenSynergic\EventManagement\Filament\Resources\EventResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Route;
use Livewire\ImplicitRouteBinding;

class EditEvent extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = EventResource::class;

    public function mount($record): void
    {
        parent::mount($record);

        // $url = url()->current();
        // $route = Route::getRoutes()->match(request()->create($url));
        // $livewire = new ($route->getControllerClass());
        // $a = (new ImplicitRouteBinding(app()))->resolveMountParameters($route, new ($route->getControllerClass()))->all();
        // dd($a);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
