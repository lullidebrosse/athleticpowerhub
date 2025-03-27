<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $exercises = auth()->user()->exercises()->latest()->get();
        return view('exercises.index', compact('exercises'));
    }

    public function create()
    {
        return view('exercises.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        auth()->user()->exercises()->create($validated);

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise created successfully.');
    }

    public function show(Exercise $exercise)
    {
        $this->authorize('view', $exercise);
        return view('exercises.show', compact('exercise'));
    }

    public function edit(Exercise $exercise)
    {
        $this->authorize('update', $exercise);
        return view('exercises.edit', compact('exercise'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        $this->authorize('update', $exercise);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $exercise->update($validated);

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise updated successfully.');
    }

    public function destroy(Exercise $exercise)
    {
        $this->authorize('delete', $exercise);
        
        $exercise->delete();

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise deleted successfully.');
    }
}