<?php

namespace OpenSynergic\Installer\Pipe\Wizard;

use Closure;
use Illuminate\Support\Facades\Artisan;
use OpenSynergic\Installer\Contracts\Pipe;

class SeedDatabase implements Pipe
{
  public function handle($content, Closure $next)
  {
    Artisan::call('db:seed', [
      '--force' => true
    ]);
  }
}
