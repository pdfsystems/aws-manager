<?php

namespace App\Livewire;

use App\Models\TargetGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListTargetGroups extends Component
{
    public function render(): View
    {
        return view('livewire.list-target-groups');
    }

    #[Computed]
    public function targetGroups(): Collection
    {
        return TargetGroup::all();
    }
}
