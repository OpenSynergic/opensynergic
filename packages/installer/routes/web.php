<?php

use Illuminate\Support\Facades\Route;
use OpenSynergic\Installer\Livewire\InstallerPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (!config('installer.installed')) {
  Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))
    ->group(function () {
      Route::get(config('installer.path'), InstallerPage::class)->name('installer.wizard');
    });
}
