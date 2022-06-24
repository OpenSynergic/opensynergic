<?php

namespace OpenSynergic\EventManagement\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class TicketsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'tickets';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->rules('required'),
                        TextInput::make('price')
                            ->label('Price')
                            ->rules('required')
                            ->mask(fn (TextInput\Mask $mask) => $mask->money('$', ',', 2))
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name'),
                TextColumn::make('price')
            ])
            ->filters([
                //
            ]);
    }
}
