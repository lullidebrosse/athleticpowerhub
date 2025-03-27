<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\PersonalRecord;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetricController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $metrics = Auth::user()->metrics()
            ->with(['exercise'])
            ->latest()
            ->paginate(10);

        $hasData = $this->hasUserData(Auth::id());
        
        return view('metrics.index', compact('metrics', 'hasData'));
    }

    public function create()
    {
        $exercises = Exercise::where('is_approved', true)->get();
        
        if ($exercises->isEmpty()) {
            return redirect()->route('exercises.create')
                ->with('warning', 'Please create an exercise before logging metrics.');
        }

        return view('metrics.create', compact('exercises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);

        $metric = Auth::user()->metrics()->create($validated);

        // Calculate and store PR if applicable
        $this->checkAndStorePR($metric);

        return redirect()->route('metrics.index')
            ->with('success', 'Metric logged successfully.');
    }

    public function show(Metric $metric)
    {
        $this->authorize('view', $metric);
        return view('metrics.show', compact('metric'));
    }

    public function edit(Metric $metric)
    {
        $this->authorize('update', $metric);
        $exercises = Exercise::where('is_approved', true)->get();
        return view('metrics.edit', compact('metric', 'exercises'));
    }

    public function update(Request $request, Metric $metric)
    {
        $this->authorize('update', $metric);

        $validated = $request->validate([
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
        ]);

        $metric->update($validated);

        // Recalculate PR if applicable
        $this->checkAndStorePR($metric);

        return redirect()->route('metrics.index')
            ->with('success', 'Metric updated successfully.');
    }

    public function destroy(Metric $metric)
    {
        $this->authorize('delete', $metric);
        
        $metric->delete();

        return redirect()->route('metrics.index')
            ->with('success', 'Metric deleted successfully.');
    }

    protected function checkAndStorePR(Metric $metric)
    {
        $calculatedValue = $metric->calculateValue();
        if (!$calculatedValue) {
            return;
        }

        $recordType = match($metric->metric_type) {
            'MAX_WEIGHT' => 'WEIGHT_BASED',
            'REP_MAX' => 'REP_BASED',
            'TIME' => 'TIME_BASED',
            'DISTANCE' => 'DISTANCE_BASED',
            'HEIGHT' => 'HEIGHT_BASED',
            'SPEED' => 'SPEED_BASED',
            default => null
        };

        if (!$recordType) {
            return;
        }

        $unit = match($metric->metric_type) {
            'MAX_WEIGHT', 'REP_MAX' => 'lbs',
            'TIME' => 'sec',
            'DISTANCE' => 'm',
            'HEIGHT' => 'in',
            'SPEED' => 'mph',
            default => null
        };

        // Check if this is a new PR
        $previousPR = Auth::user()->getLatestPR($metric->exercise_id, $recordType);
        $isNewPR = !$previousPR || match($recordType) {
            'WEIGHT_BASED', 'REP_BASED', 'DISTANCE_BASED', 'HEIGHT_BASED', 'SPEED_BASED' => 
                $calculatedValue > $previousPR->calculated_value,
            'TIME_BASED' => $calculatedValue < $previousPR->calculated_value,
            default => false
        };

        if ($isNewPR) {
            PersonalRecord::create([
                'user_id' => Auth::id(),
                'exercise_id' => $metric->exercise_id,
                'metric_id' => $metric->id,
                'record_type' => $recordType,
                'calculated_value' => $calculatedValue,
                'unit' => $unit,
                'reps' => $metric->reps,
                'notes' => $metric->notes,
                'achieved_at' => $metric->performed_at ?? now()
            ]);
        }
    }

    protected function hasUserData($userId)
    {
        return Metric::where('user_id', $userId)->exists();
    }
} 