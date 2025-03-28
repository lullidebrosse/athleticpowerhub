<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\ExerciseLog;
use App\Models\SetEntry;

class ExerciseLogController extends Controller
{
    public function create(Exercise $exercise)
    {
        return view('exercise-logs.create', compact('exercise'));
    }

    public function store(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
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
            'sets.*.meta_data' => 'nullable|array'
        ]);

        $exerciseLog = ExerciseLog::create([
            'user_id' => auth()->id(),
            'exercise_id' => $exercise->id,
            'log_date' => $validated['log_date'],
            'notes' => $validated['notes'] ?? null
        ]);

        foreach ($validated['sets'] as $setData) {
            $setData['exercise_log_id'] = $exerciseLog->id;
            SetEntry::create($setData);
        }

        return redirect()->route('exercise-logs.index')
            ->with('success', 'Exercise logged successfully!');
    }

    public function index()
    {
        $exerciseLogs = ExerciseLog::with(['exercise', 'setEntries'])
            ->where('user_id', auth()->id())
            ->orderBy('log_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('exercise-logs.index', compact('exerciseLogs'));
    }
}
