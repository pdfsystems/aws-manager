<?php

namespace App\Livewire;

use App\Models\Incident;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListIncidents extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.list-incidents', [
            'incidents' => $this->getIncidentBuilder()->paginate(),
        ]);
    }

    /**
     * @return Builder<Incident>
     */
    #[Computed]
    public function getIncidentBuilder(): Builder
    {
        return Incident::withTrashed()->orderByDesc('created_at');
    }
}
