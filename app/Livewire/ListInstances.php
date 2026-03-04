<?php

namespace App\Livewire;

use App\Models\Instance;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Instances')]
class ListInstances extends Component
{
    public function render(): View
    {
        return view('livewire.list-instances');
    }

    #[Computed]
    public function instances(): Collection
    {
        return Instance::orderBy('name')->get();
    }
}
