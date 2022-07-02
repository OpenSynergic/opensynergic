<?php

namespace OpenSynergic\Installer\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class EnsureApplicationIsInstalled
{
    public function handle(Request $request, \Closure $next)
    {
        $exceptRoutes = [
            'installer.wizard',
            'filament.asset',
            'livewire.message',
            'livewire.preview-file',
            'livewire.upload-file'
        ];

        if (!Config::get('installer.installed') && !in_array(Route::current()->getName(), $exceptRoutes)) {
            return redirect()->route('installer.wizard');
        }

        return $next($request);
    }
}
