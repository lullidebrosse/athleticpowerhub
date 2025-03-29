<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\ExerciseLog;
use App\Models\SetEntry;
use Livewire\Component;

class ExerciseLogForm extends Component
{
    public Exercise $exercise;
    public $log_date;
    public $notes;
    public $sets = [];
    
    public function mount(Exercise $exercise)
    {
        $this->exercise = $exercise;
        $this->log_date = date('Y-m-d');
        
        // Check if we have copy data from a previous workout
        if (session()->has('copy_data')) {
            $copyData = session('copy_data');
            $this->sets = $copyData['sets'];
        } else {
            $this->addSet();
        }
    }

    public function addSet()
    {
        $this->sets[] = [
            'set_number' => count($this->sets) + 1,
            'reps' => '',
            'weight' => '',
            'weight_unit' => '',
            'time' => '',
            'time_unit' => '',
            'distance' => '',
            'distance_unit' => '',
            'rest_duration_after_set' => '',
            'meta_data' => ''
        ];
    }

    public function copySet($index)
    {
        if ($index > 0) {
            $previousSet = $this->sets[$index - 1];
            $this->sets[$index] = array_merge($previousSet, [
                'set_number' => $index + 1,
                'meta_data' => '' // Don't copy meta data
            ]);
        }
    }

    public function removeSet($index)
    {
        unset($this->sets[$index]);
        $this->sets = array_values($this->sets);
        // Reorder set numbers
        foreach ($this->sets as $i => $set) {
            $this->sets[$i]['set_number'] = $i + 1;
        }
    }

    public function save()
    {
        $this->validate([
            'log_date' => 'required|date',
            'notes' => 'nullable|string',
            'sets' => 'required|array|min:1',
            'sets.*.set_number' => 'required|integer|min:1',
            'sets.*.reps' => 'nullable|integer|min:1',
            'sets.*.weight' => 'nullable|numeric|min:0',
            'sets.*.weight_unit' => 'nullable|string|in:kg,lbs',
            'sets.*.time' => 'nullable|numeric|min:0',
            'sets.*.time_unit' => 'nullable|string|in:sec,min',
            'sets.*.distance' => 'nullable|numeric|min:0',
            'sets.*.distance_unit' => 'nullable|string|in:m,km,yd,mi',
            'sets.*.rest_duration_after_set' => 'nullable|integer|min:0',
            'sets.*.meta_data' => 'nullable|string'
        ]);

        $exerciseLog = ExerciseLog::create([
            'user_id' => auth()->id(),
            'exercise_id' => $this->exercise->id,
            'log_date' => $this->log_date,
            'notes' => $this->notes
        ]);

        foreach ($this->sets as $setData) {
            // Convert empty strings to null for numeric fields
            $setData['reps'] = $setData['reps'] ?: null;
            $setData['weight'] = $setData['weight'] ?: null;
            $setData['time'] = $setData['time'] ?: null;
            $setData['distance'] = $setData['distance'] ?: null;
            $setData['rest_duration_after_set'] = $setData['rest_duration_after_set'] ?: null;
            
            // Convert empty strings to null for unit fields
            $setData['weight_unit'] = $setData['weight_unit'] ?: null;
            $setData['time_unit'] = $setData['time_unit'] ?: null;
            $setData['distance_unit'] = $setData['distance_unit'] ?: null;

            $setData['exercise_log_id'] = $exerciseLog->id;
            if (!empty($setData['meta_data'])) {
                $setData['meta_data'] = json_encode(['notes' => $setData['meta_data']]);
            } else {
                $setData['meta_data'] = null;
            }
            
            SetEntry::create($setData);
        }

        session()->flash('message', 'Exercise logged successfully!');
        return redirect()->route('exercise-logs.index');
    }

    public function render()
    {
        return view('livewire.exercise-log-form');
    }
}
