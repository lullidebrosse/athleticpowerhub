<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Component;
use Livewire\WithPagination;

class ExerciseSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 9;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $exercises = Exercise::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.exercise-search', [
            'exercises' => $exercises
        ]);
    }
} 