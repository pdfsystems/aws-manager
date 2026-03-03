<?php

use App\Livewire\ListTargetGroups;
use App\Models\TargetGroup;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('target-groups', ListTargetGroups::class)->name('target-groups.index')->middleware('can:viewAny,'.TargetGroup::class);
});

require __DIR__.'/settings.php';
