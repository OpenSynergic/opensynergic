<?php

namespace OpenSynergic\EventManagement\Filament\Resources;

use OpenSynergic\EventManagement\Filament\Resources\EventResource\Pages;
use OpenSynergic\EventManagement\Filament\Resources\EventResource\RelationManagers;
use OpenSynergic\EventManagement\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use OpenSynergic\EventManagement\Enums\EventStatus;
use OpenSynergic\EventManagement\Enums\EventType;

class EventResource extends Resource
{
    use Translatable;

    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return __('event-management::event-management.nav.group');
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'es', 'id', 'ru'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->rules('required'),
                        DatePicker::make('date')
                            ->minDate(now())
                            ->label('Date')
                            ->rules('required'),
                        TimePicker::make('time')
                            ->withoutSeconds()
                            ->label('Time')
                            ->rules('required'),
                        Select::make('type')
                            ->label('Type')
                            ->options(EventType::toArray())
                            ->rules('required'),
                        Select::make('status')
                            ->label('Status')
                            ->options(EventStatus::toArray())
                            ->rules('required'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('time')
                    ->label('Time')
                    ->sortable(),
                BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'danger' => 'OFFLINE',
                        'success' => 'ONLINE',
                    ]),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'DRAFT',
                        'success' => 'PUBLISHED',
                        'warning' => 'ARCHIVED',
                    ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(EventStatus::toArray()),
                SelectFilter::make('type')
                    ->label('Type')
                    ->options(EventType::toArray()),
                Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from'),
                        Forms\Components\DatePicker::make('date_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TicketsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}'),
        ];
    }
}
