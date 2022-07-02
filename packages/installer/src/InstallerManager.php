<?php

namespace OpenSynergic\Installer;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Actions\Action;
use OpenSynergic\Installer\Rules\ConnectDatabase;

class InstallerManager
{
  protected ?array $steps = [];
  protected ?array $actions = [];
  protected ?Wizard $wizard = null;

  public function __construct()
  {
    $this->steps = $this->defaultSteps();
    $this->wizard = $this->defaultWizard();
    $this->actions = $this->defaultActions();
  }

  public function defaultActions()
  {
    return config('installer.installing.actions', []);
  }

  public function defaultSteps(): array
  {
    return [
      Wizard\Step::make('database')
        ->label('Database')
        ->icon('heroicon-o-database')
        ->schema([
          TextInput::make('DB_DATABASE')
            ->rule(new ConnectDatabase())
            ->label('Database Name')
            ->required(),
          TextInput::make('DB_USERNAME')
            ->label('Database Username')
            ->default(config('database.connections.mysql.username'))
            ->required(),
          TextInput::make('DB_PASSWORD')
            ->label('Database Password')
            ->default(config('database.connections.mysql.password'))
            ->password()
            ->required(),
          TextInput::make('DB_HOST')
            ->label('Database Host')
            ->default(config('database.connections.mysql.host'))
            ->required(),
          TextInput::make('DB_PORT')
            ->label('Database Port')
            ->default(config('database.connections.mysql.port'))
            ->required(),
          Checkbox::make('create_db')
            ->label('Create Database')
            ->default(false),
        ]),
    ];
  }

  public function defaultWizard(): Wizard
  {
    return Wizard::make()
      ->label('Install')
      ->submitAction($this->getInstallAction());
  }

  public function getInstallAction()
  {
    return Action::make('install')
      ->label('Install')
      ->submit('install')
      ->keyBindings(['mod+s']);
  }

  public function wizard(Wizard $wizard)
  {
    $this->wizard = $wizard;

    return $this;
  }

  public function getWizard(): Wizard
  {
    return $this->wizard;
  }

  public function getSteps(): ?array
  {
    return $this->steps;
  }

  public function steps(array $steps): self
  {
    $this->steps = $steps;

    return $this;
  }

  public function appendStep(array $data): self
  {
    $this->steps = array_merge($this->steps, $data);

    return $this;
  }

  public function prependStep(array $data): self
  {
    $this->steps = array_merge($data, $this->steps);

    return $this;
  }

  public function getActions(): array
  {
    return $this->actions;
  }

  public function actions(array $actions): self
  {
    $this->actions = $actions;

    return $this;
  }

  public function appendActions(string $action): self
  {
    $this->actions[] = $action;

    return $this;
  }

  public function prependActions(array $action): self
  {
    $this->actions = array_merge($action, $this->actions);

    return $this;
  }
}
