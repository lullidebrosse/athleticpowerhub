<?php

namespace App\Livewire;

use App\Models\Metric;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class MetricForm extends Component
{
    public $exercise_id;
    public $load;
    public $reps;
    public $sets;
    public $duration;
    public $distance;
    public $height;
    public $speed;
    public $notes;
    public $performed_at;
    public $metric_type = 'MAX_WEIGHT';

    protected $rules = [
        'exercise_id' => 'required|exists:exercises,id',
        'metric_type' => 'required|in:MAX_WEIGHT,REP_MAX,DENSITY,TIME,DISTANCE,HEIGHT,SPEED',
        'load' => 'nullable|numeric|min:0',
        'reps' => 'nullable|integer|min:1',
        'sets' => 'nullable|integer|min:1',
        'duration' => 'nullable|numeric|min:0',
        'distance' => 'nullable|numeric|min:0',
        'height' => 'nullable|numeric|min:0',
        'speed' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'performed_at' => 'nullable|date'
    ];

    public function mount()
    {
        $this->performed_at = now()->format('Y-m-d\TH:i');
    }

    #[On('set-exercise-id')]
    public function setExerciseId($exerciseId)
    {
        $this->exercise_id = $exerciseId;
    }

    public function store()
    {
        $this->validate();

        // Convert empty strings to null for decimal fields
        $data = [
            'exercise_id' => $this->exercise_id,
            'metric_type' => $this->metric_type,
            'load' => $this->load ?: null,
            'reps' => $this->reps ?: null,
            'sets' => $this->sets ?: null,
            'duration' => $this->duration ?: null,
            'distance' => $this->distance ?: null,
            'height' => $this->height ?: null,
            'speed' => $this->speed ?: null,
            'notes' => $this->notes,
            'performed_at' => $this->performed_at
        ];

        $metric = Auth::user()->metrics()->create($data);

        return redirect()->route('metrics.index')
            ->with('success', 'Metric logged successfully.');
    }

    public function render()
    {
        return view('livewire.metric-form');
    }
} 