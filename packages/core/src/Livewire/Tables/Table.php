<?php

namespace OpenSynergic\Core\Livewire\Tables;

use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

abstract class Table extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('core::livewire.tables.table');
    }
}
