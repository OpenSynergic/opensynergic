<?php

namespace OpenSynergic\Core\Livewire\Tables;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\{
  TextColumn,
  BadgeColumn
};
use Spatie\Permission\Models\Role;

class Roles extends Table
{
  protected function getTableQuery(): Builder
  {
    return config('permission.models.role', Role::class)::query();
  }

  protected function getTableColumns(): array
  {
    return [
      BadgeColumn::make('name')
        ->label(__('filament-shield::filament-shield.column.name'))
        ->formatStateUsing(fn ($state): string => Str::headline($state))
        ->colors(['primary'])
        ->searchable(),
      BadgeColumn::make('permissions_count')
        ->label(__('filament-shield::filament-shield.column.permissions'))
        ->counts('permissions')
        ->colors(['success']),
      TextColumn::make('updated_at')
        ->label(__('filament-shield::filament-shield.column.updated_at'))
        ->dateTime(),
    ];
  }
}
