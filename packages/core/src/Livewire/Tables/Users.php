<?php

namespace OpenSynergic\Core\Livewire\Tables;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class Users extends Table
{
    protected function getTableQuery(): Builder
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
      TextColumn::make('name'),
      TextColumn::make('email'),
    ];
    }
}
