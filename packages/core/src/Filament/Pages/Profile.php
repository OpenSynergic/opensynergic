<?php

namespace OpenSynergic\Core\Filament\Pages;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\{Grid, Section, SpatieMediaLibraryFileUpload, TextInput};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions\Action;
use Filament\Pages\Concerns\HasFormActions;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use OpenSynergic\Hooks\Facades\Hook;

class Profile extends Page implements HasForms
{
    use InteractsWithForms, HasFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'core::filament.pages.profile';

    protected static bool $shouldRegisterNavigation = false;

    protected function getFormModel(): Model | string | null
    {
        return Filament::auth()->user();
    }

    public function mount()
    {
        $this->form->fill([
            'name' => $this->getFormModel()->name,
            'email' => $this->getFormModel()->email,
        ]);
    }

    public function save()
    {
        $state = array_filter($this->form->getState());

        auth()->user()->update($state);

        if (isset($state['password'])) {
            // TODO regenerate api token when password is changed
            // prevent logged out when changing user password
            $user = config('auth.providers.users.model', User::class)::find(auth()->user()->id);
            Session::flush();
            Filament::auth()->login($user, !!$user->getRememberToken());
        }

        $this->notify('success', 'Your profile has been updated.');
    }


    protected function getFormSchema(): array
    {
        $schema = [
            Grid::make(3)
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Section::make('General')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    TextInput::make('email')
                                        ->label('Email Address')
                                        ->required(),
                                ]),
                            Section::make('Update Password')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('current_password')
                                        ->label('Current Password')
                                        ->password()
                                        ->dehydrated(false)
                                        ->rules(['required_with:password'])
                                        ->currentPassword()
                                        ->autocomplete('off')
                                        ->columnSpan(1),
                                    Grid::make()
                                        ->schema([
                                            TextInput::make('password')
                                                ->label('New Password')
                                                ->password()
                                                ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : null)
                                                ->same('new_password_confirmation')
                                                ->autocomplete('new-password'),
                                            TextInput::make('new_password_confirmation')
                                                ->label('Confirm Password')
                                                ->dehydrated(false)
                                                ->password()
                                                ->rules([
                                                    'required_with:password',
                                                ])
                                                ->autocomplete('new-password'),
                                        ]),
                                ]),
                        ])
                        ->columnSpan([
                            'sm' => 3,
                            'lg' => 2
                        ]),
                    Grid::make(1)
                        ->schema([
                            Section::make('Picture')
                                ->schema([
                                    SpatieMediaLibraryFileUpload::make('profile')
                                        ->collection('profile')
                                        ->avatar()
                                ])
                        ])
                        ->columnSpan([
                            'sm' => 3,
                            'lg' => 1
                        ])
                ]),
        ];

        Hook::call(static::class . '::getFormSchema', $schema);

        return $schema;
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label(__('filament::resources/pages/edit-record.form.actions.save.label'))
                ->submit('create')
                ->keyBindings(['mod+s']),
        ];
    }
}
