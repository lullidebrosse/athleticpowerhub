<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::orderBy('name')->get();
        return view('exercises.index', compact('exercises'));
    }
}
