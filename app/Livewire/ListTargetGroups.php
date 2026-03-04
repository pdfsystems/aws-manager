<?php

namespace App\Livewire;

use App\Models\TargetGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Target Groups')]
class ListTargetGroups extends Component
{
    public function render(): View
    {
        return view('livewire.list-target-groups');
    }

    #[Computed]
    public function targetGroups(): Collection
    {
        return TargetGroup::query()
            ->with('targets.instance')
            ->get();
    }
}
