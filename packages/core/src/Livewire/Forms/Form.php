<?php

namespace OpenSynergic\Core\Livewire\Forms;

use Filament\Forms\Concerns\InteractsWithForms;
use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Concerns\HasFormActions;

abstract class Form extends Component implements HasForms
{
  use InteractsWithForms, HasFormActions;

  public function render()
  {
    return view('core::livewire.forms.form');
  }
}
