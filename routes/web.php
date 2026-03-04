<?php

use App\Livewire\EditInstance;
use App\Livewire\ListIncidents;
use App\Livewire\ListInstances;
use App\Livewire\ListTargetGroups;
use App\Models\Incident;
use App\Models\Instance;
use App\Models\TargetGroup;
use Illuminate\Support\Facades\Route;
use Laravel\Nightwatch\Http\Middleware\Sample;
use Spatie\Health\Http\Controllers\HealthCheckJsonResultsController;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/health', HealthCheckResultsController::class)->name('health');
Route::get('/health.json', HealthCheckJsonResultsController::class)->name('health.json')->middleware(Sample::never());

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('target-groups', ListTargetGroups::class)->name('target-groups.index')->middleware('can:viewAny,'.TargetGroup::class);
    Route::livewire('target-groups/{group}', \App\Livewire\EditTargetGroup::class)->name('target-groups.edit')->middleware('can:update,group');
    Route::livewire('incidents', ListIncidents::class)->name('incidents.index')->middleware('can:viewAny,'.Incident::class);
    Route::livewire('instances', ListInstances::class)->name('instances.index')->middleware('can:viewAny,'.Instance::class);
    Route::livewire('instances/{instance}', EditInstance::class)->name('instances.edit')->middleware('can:update,instance');
});

require __DIR__.'/settings.php';
