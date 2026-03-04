<?php

namespace App\Livewire;

use App\Models\Instance;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Edit Instance')]
class EditInstance extends Component
{
    public Instance $instance;

    #[Validate(['nullable', 'string'])]
    public ?string $display_name = '';

    public function mount(): void
    {
        $this->display_name = $this->instance->display_name;
    }

    public function render(): View
    {
        return view('livewire.edit-instance');
    }

    public function save(): void
    {
        $this->instance->update($this->validate());

        Flux::toast('Instanced Updated', variant: 'success');
    }
}
