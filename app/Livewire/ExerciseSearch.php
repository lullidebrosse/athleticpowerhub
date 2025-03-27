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
        $this->exercises = Exercise::where('name', 'like', '%' . $this->search . '%')
            ->take(5)
            ->get();
    }

    public function selectExercise($exerciseId)
    {
        $this->selectedExercise = Exercise::find($exerciseId);
        $this->search = $this->selectedExercise ? $this->selectedExercise->name : '';
        $this->exercises = [];
    }

    public function render()
    {
        return view('livewire.exercise-search');
    }
} 