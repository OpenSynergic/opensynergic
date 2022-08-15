<?php

namespace OpenSynergic\PaymentGateway\Filament\Pages\Settings;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use OpenSynergic\PaymentGateway\Models\PaymentGateway as PaymentGatewayModel;
use Squire\Models\Currency;

class PaymentGateway extends Page implements HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public $generalFormData;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Payments';
    
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static string $view = 'payment-gateway-manager::filament.pages.settings.payment-gateway';

    public function mount()
    {
        $this->fillGeneralForm();
    }

    /** ------ table ------ */
    protected function getTableQuery(): Builder|Relation
    {
        return PaymentGatewayModel::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->extraAttributes(['class' => 'font-semibold'])
                ->searchable()
                ->sortable(),
            TextColumn::make('description'),
            TextColumn::make('Enabled')
        ];
    }
    /** ------ end table */

    /** ------ form ------ */
    protected function fillGeneralForm()
    {
        $this->generalForm->fill(setting('payments.general', []));
    }

    protected function getForms(): array
    {
        return [
            'generalForm' => $this->makeForm()
                ->schema($this->getGeneralFormSchema())
                ->statePath('generalFormData')
        ];
    }

    protected function getGeneralFormSchema(): array
    {
        return [
            Fieldset::make('Enable')
                ->schema([
                    Toggle::make('enable')
                        ->reactive()
                        ->label('Payments will be enabled for this application. Note that users will be required to log in to make payments.'),
                ])->columns(1),            
            Fieldset::make('Address')
                ->visible(fn ($get) => $get('enable'))
                ->schema([
                    Select::make('currency')
                        ->required()
                        ->options(once(fn () => Currency::all()->mapWithKeys(fn ($currency) => [$currency->id => $currency->name])))
                        ->optionsLimit(Currency::count())
                        ->searchable(),
                    Grid::make()
                        ->schema([
                            TextInput::make('address1')->label('Address line 1')->placeholder('Enter a address'),
                            TextInput::make('address2')->label('Address line 2')->placeholder('Enter a address')
                        ])
                ])->columns(1)
        ];
    }

    public function submitGeneralForm()
    {
        $data = $this->generalForm->getState();
        setting(['payments.general' => $data]);

        Notification::make()
            ->title('Payments settings updated')
            ->success()
            ->send();
    }
    /** ------ end form ------ */
}
