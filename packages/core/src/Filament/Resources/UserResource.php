<?php

namespace OpenSynergic\Core\Filament\Resources;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use OpenSynergic\Core\Filament\Resources\UserResource\Pages;
use OpenSynergic\Hooks\Facades\Hook;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use STS\FilamentImpersonate\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    // protected static ?string $modelLabel = "Uasdsaa";

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModel(): string
    {
        return config('auth.providers.users.model') ?? static::$model;
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('core::navigation.groups.settings');
    }

    protected static function getNavigationLabel(): string
    {
        return __('core::resources/user.navigation.label');
    }


    public static function form(Form $form): Form
    {
        $schemas = [
            Grid::make()
                ->schema([
                    SpatieMediaLibraryFileUpload::make('profile')
                        ->avatar()
                        ->collection('profile')
                        ->visible(fn () => is_a(static::getModel(), HasMedia::class, true)),
                    TextInput::make('name')
                        ->label(__('core::resources/user.form.field.name.label'))
                        ->required(),
                    TextInput::make('email')
                        ->unique(table: static::getModel(), ignorable: fn (?User $record): ?User => $record)
                        ->label(__('core::resources/user.form.field.email.label'))
                        ->email()
                        ->required(),
                ])
                ->columns(1),
            TextInput::make('password')
                ->same('confirm_password')
                ->label(__('core::resources/user.form.field.password.label'))
                ->password()
                ->maxLength(255)
                ->hidden(fn (?User $record): ?User => $record)
                ->required(fn ($record) =>  $record === null)
                ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : ""),
            TextInput::make('confirm_password')
                ->label(__('core::resources/user.form.field.confirm_password.label'))
                ->hidden(fn (?User $record): ?User => $record)
                ->password()
                ->dehydrated(false)
                ->maxLength(255),
            CheckboxList::make('roles')
                ->relationship('roles', 'name')
                ->hidden(fn () => !in_array(HasRoles::class, class_uses_recursive(static::getModel())))
                ->columns([
                    'sm' => 2,
                ])
                ->getOptionLabelFromRecordUsing(fn (Role $record) => Str::headline($record->name))
                ->columnSpan([
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 2,
                ])
        ];

        Hook::call(static::class . '::form::schemas', $schemas);

        $form->schema($schemas);

        Hook::call(static::class . '::form', $form);

        return $form;
    }

    public static function table(Table $table): Table
    {
        $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('profile')
                    ->rounded()
                    ->visible(fn () => is_a(static::getModel(), HasMedia::class, true))
                    ->toggleable()
                    ->collection('profile')
                    ->conversion('thumbnail'),
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->label(__('core::resources/user.table.columns.name')),
                Tables\Columns\BadgeColumn::make('roles.name')
                    ->label(__('core::resources/user.table.columns.role'))
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => Str::headline($state) ?? '-')
                    ->colors(['primary'])
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->toggleable()
                    ->label(__('core::resources/user.table.columns.email'))
                    ->searchable()
            ])
            ->actions([
                ActionGroup::make([
                    Impersonate::make('impersonate')
                        ->label(__('core::resources/user.table.actions.login_as')),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->recordTitle(fn ($record): string => $record->name),
                ])
            ])
            ->filters([
                Tables\Filters\MultiSelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->label(__('core::resources/user.table.filters.role'))
                    ->hidden(fn () => !in_array(HasRoles::class, class_uses_recursive(static::getModel())))
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);

        Hook::call(static::class . '::table', $table);

        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
