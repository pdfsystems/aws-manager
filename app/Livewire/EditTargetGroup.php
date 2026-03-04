<?php

namespace App\Livewire;

use App\Models\TargetGroup;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditTargetGroup extends Component
{
    public TargetGroup $group;

    #[Validate(['nullable', 'string'])]
    public ?string $display_name = null;

    public function mount(): void
    {
        $this->display_name = $this->group->display_name;
    }

    public function render(): View
    {
        return view('livewire.edit-target-group');
    }

    public function save(): void
    {
        $this->group->update($this->validate());

        Flux::toast('Target Group Updated', variant: 'success');
    }
}
