<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Component;

class ExerciseSearch extends Component
{
    public $search = '';
    public $exercises = [];
    public $selectedExercise = null;
    public $previousMetrics = [];
    public $selectedMetric = null;

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
        
        // Load previous metrics for the selected exercise
        if ($this->selectedExercise) {
            $this->previousMetrics = auth()->user()->metrics()
                ->where('exercise_id', $exerciseId)
                ->latest()
                ->take(5)
                ->get();
        }
    }

    public function selectMetric($metricId)
    {
        $this->selectedMetric = auth()->user()->metrics()->find($metricId);
        if ($this->selectedMetric) {
            $this->dispatch('prefill-metric', [
                'load' => $this->selectedMetric->load,
                'reps' => $this->selectedMetric->reps,
                'sets' => $this->selectedMetric->sets,
                'duration' => $this->selectedMetric->duration,
                'distance' => $this->selectedMetric->distance,
                'height' => $this->selectedMetric->height,
                'speed' => $this->selectedMetric->speed,
                'notes' => $this->selectedMetric->notes,
                'performed_at' => $this->selectedMetric->performed_at ? $this->selectedMetric->performed_at->format('Y-m-d\TH:i') : null
            ]);
        }
    }

    public function render()
    {
        return view('livewire.exercise-search');
    }
} 