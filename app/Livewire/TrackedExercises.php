<?php

namespace App\Livewire;

use App\Models\Exercise;
use Livewire\Component;
use App\Models\Metric;
use Illuminate\Support\Facades\Log;

class TrackedExercises extends Component
{
    public $trackedExercises = [];

    public function mount()
    {
        Log::debug('TrackedExercises component mounted');
        $this->loadTrackedExercises();
        Log::debug('Tracked exercises loaded: ' . $this->trackedExercises->count());
    }

    public function loadTrackedExercises()
    {
        $this->trackedExercises = Exercise::whereHas('metrics', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->orderBy('name')
        ->get();
        
        Log::debug('Tracked exercises query executed');
        Log::debug('Found exercises: ' . $this->trackedExercises->pluck('name')->join(', '));
    }

    public function selectExercise($exerciseId)
    {
        Log::debug('TrackedExercises::selectExercise called with ID: ' . $exerciseId);
        
        $exercise = Exercise::find($exerciseId);
        Log::debug('Exercise found: ' . ($exercise ? $exercise->name : 'null'));
        
        if ($exercise) {
            $this->dispatch('set-exercise-id', exerciseId: $exerciseId);
            
            $latestMetric = Metric::where('exercise_id', $exerciseId)
                ->where('user_id', auth()->id())
                ->latest()
                ->first();
            
            Log::debug('Latest metric found: ' . ($latestMetric ? 'yes' : 'no'));
            
            if ($latestMetric) {
                $data = [
                    'exercise_id' => $exercise->id,
                    'exercise_name' => $exercise->name,
                    'load' => $latestMetric->load,
                    'reps' => $latestMetric->reps,
                    'sets' => $latestMetric->sets,
                    'duration' => $latestMetric->duration,
                    'distance' => $latestMetric->distance,
                    'speed' => $latestMetric->speed,
                    'height' => $latestMetric->height,
                ];
                
                Log::debug('Event data: ' . json_encode($data));
                $this->dispatch('prefill-metric', $data);
            } else {
                Log::debug('No latest metric found for exercise');
            }
        } else {
            Log::debug('Exercise not found with ID: ' . $exerciseId);
        }
    }

    public function render()
    {
        Log::debug('Rendering TrackedExercises component');
        return view('livewire.tracked-exercises');
    }
} 