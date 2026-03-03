<?php

use App\Livewire\ListTargetGroups;
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
});

require __DIR__.'/settings.php';
