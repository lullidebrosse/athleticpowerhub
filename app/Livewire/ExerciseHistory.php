<?php

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\ExerciseLog;
use Livewire\Component;
use Livewire\WithPagination;

class ExerciseHistory extends Component
{
    use WithPagination;

    public $selectedExercise = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;
    public $sortBy = 'log_date';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->dateFrom = now()->subMonths(3)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function updatingSelectedExercise()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function copyLastWorkout(ExerciseLog $log)
    {
        return redirect()->route('exercise-logs.create', $log->exercise)
            ->with('copy_data', [
                'sets' => $log->setEntries->map(function ($set) {
                    return [
                        'reps' => $set->reps,
                        'weight' => $set->weight,
                        'weight_unit' => $set->weight_unit,
                        'time' => $set->time,
                        'time_unit' => $set->time_unit,
                        'distance' => $set->distance,
                        'distance_unit' => $set->distance_unit,
                        'rest_duration_after_set' => $set->rest_duration_after_set,
                        'meta_data' => $set->meta_data
                    ];
                })->toArray()
            ]);
    }

    public function render()
    {
        // Get only exercises that the user has logged before
        $exercises = Exercise::whereHas('exerciseLogs', function ($query) {
            $query->where('user_id', auth()->id());
        })->orderBy('name')->get();
        
        $query = ExerciseLog::with(['exercise', 'setEntries'])
            ->where('user_id', auth()->id())
            ->when($this->selectedExercise, function ($query) {
                $query->where('exercise_id', $this->selectedExercise);
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('log_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('log_date', '<=', $this->dateTo);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        $exerciseLogs = $query->paginate($this->perPage);
        
        // Group logs by month for the timeline view
        $groupedLogs = $exerciseLogs->groupBy(function ($log) {
            return $log->log_date->format('F Y');
        });

        return view('livewire.exercise-history', [
            'exercises' => $exercises,
            'exerciseLogs' => $exerciseLogs,
            'groupedLogs' => $groupedLogs
        ]);
    }
} 