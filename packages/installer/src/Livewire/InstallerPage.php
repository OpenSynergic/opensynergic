<?php

namespace OpenSynergic\Installer\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Pipeline\Pipeline;
use OpenSynergic\Installer\Facades\Installer;
use OpenSynergic\Installer\Pipe\Wizard\UpdateEnvData;

class InstallerPage extends Component implements HasForms
{
  use InteractsWithForms;

  public $data;

  protected static string $layout = 'installer::components.layouts.card';

  protected static string $view = 'installer::installer';

  public function mount(): void
  {
    if (config('installer.installed')) {
      redirect()->intended(Filament::getUrl());
    }

    $this->form->fill();
  }

  public function render(): View
  {
    return view(static::$view, $this->getViewData())
      ->layout(static::$layout, $this->getLayoutData());
  }

  public function getTitle(): string
  {
    return config('installer.page.title', 'Wizard Installer');
  }

  protected function getFormStatePath(): string
  {
    return 'data';
  }

  protected function getFormSchema(): array
  {
    $wizard = Installer::getWizard();

    return [
      $wizard
        ->steps(Installer::getSteps()),
    ];
  }

  public function install()
  {
    app(Pipeline::class)
      ->send($this->form->getState())
      ->through($this->getActions())
      ->thenReturn();

    app(UpdateEnvData::class)->updateEnv(['APP_INSTALLED' => 'true']);

    return $this->redirectRoute(config('installer.installing.redirect'));
  }

  protected function getActions(): array
  {
    return Installer::getActions();
  }

  protected function getViewData(): array
  {
    return [];
  }

  protected function getLayoutData(): array
  {
    return [
      'title' => $this->getTitle(),
    ];
  }
}
