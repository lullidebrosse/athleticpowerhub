<?php

namespace App\Http\Controllers;

use App\Models\PersonalRecord;
use App\Models\Exercise;
use App\Models\Metric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $prs = Auth::user()->personalRecords()
            ->with(['exercise', 'metric'])
            ->latest()
            ->paginate(10);

        $hasData = $this->hasUserData(Auth::id());
        
        return view('personal-records.index', compact('prs', 'hasData'));
    }

    public function show(PersonalRecord $personalRecord)
    {
        $this->authorize('view', $personalRecord);
        return view('personal-records.show', compact('personalRecord'));
    }

    public function byExercise(Exercise $exercise)
    {
        $prs = Auth::user()->getExercisePRs($exercise->id);
        
        if ($prs->isEmpty()) {
            return redirect()->route('metrics.create', ['exercise_id' => $exercise->id])
                ->with('info', 'No personal records found for this exercise. Log a metric to create one!');
        }

        return view('personal-records.by-exercise', compact('exercise', 'prs'));
    }

    public function destroy(PersonalRecord $personalRecord)
    {
        $this->authorize('delete', $personalRecord);
        
        $personalRecord->delete();

        return redirect()->route('personal-records.index')
            ->with('success', 'Personal record deleted successfully.');
    }

    public function dashboard()
    {
        $hasData = $this->hasUserData(Auth::id());
        
        if (!$hasData) {
            return view('personal-records.dashboard', compact('hasData'));
        }

        $recentPRs = Auth::user()->personalRecords()
            ->with(['exercise'])
            ->latest()
            ->take(5)
            ->get();

        $topExercises = Auth::user()->personalRecords()
            ->with(['exercise'])
            ->select('exercise_id')
            ->selectRaw('COUNT(*) as pr_count')
            ->groupBy('exercise_id')
            ->orderByDesc('pr_count')
            ->take(5)
            ->get();

        return view('personal-records.dashboard', compact('recentPRs', 'topExercises', 'hasData'));
    }

    protected function hasUserData($userId)
    {
        return PersonalRecord::where('user_id', $userId)->exists();
    }
} 