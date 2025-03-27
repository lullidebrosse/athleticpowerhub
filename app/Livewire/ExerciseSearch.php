<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Component;

class ExerciseSearch extends Component
{
    public $search = '';
    public $exercises = [];
    public $selectedExercise = null;

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->exercises = Exercise::where('is_approved', true)
                ->where('name', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get();
        } else {
            $this->exercises = [];
        }
    }

    public function selectExercise($exerciseId)
    {
        $this->selectedExercise = Exercise::find($exerciseId);
        $this->search = $this->selectedExercise->name;
        $this->exercises = [];
    }

    public function render()
    {
        return view('livewire.exercise-search');
    }
} 