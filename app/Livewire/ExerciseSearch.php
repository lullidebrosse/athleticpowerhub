<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Component;

class ExerciseSearch extends Component
{
    public $search = '';

    public function render()
    {
        $query = Exercise::query();

        if (strlen(trim($this->search)) > 0) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        return view('livewire.exercise-search', [
            'exercises' => $query->limit(5)->get()
        ]);
    }
} 