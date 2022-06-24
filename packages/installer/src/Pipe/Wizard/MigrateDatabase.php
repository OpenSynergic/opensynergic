<?php

namespace OpenSynergic\Installer\Pipe\Wizard;

use Closure;
use Illuminate\Support\Facades\Artisan;
use OpenSynergic\Installer\Contracts\Pipe;

class MigrateDatabase implements Pipe
{
  public function handle($content, Closure $next)
  {
    config(['database.connections.mysql.database' => $content['DB_DATABASE']]);

    \DB::disconnect();

    Artisan::call('migrate:fresh', [
      '--force' => true
    ]);

    return $next($content);
  }
}
