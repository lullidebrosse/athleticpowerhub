<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\PersonalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hasData = $this->hasUserData($user->id);
        
        if (!$hasData) {
            return view('dashboard', compact('hasData'));
        }

        // Get the latest PRs for different types of exercises
        $benchPressPR = $user->personalRecords()
            ->with(['exercise'])
            ->whereHas('exercise', function ($query) {
                $query->where('name', 'like', '%Bench Press%');
            })
            ->where('record_type', 'WEIGHT_BASED')
            ->latest()
            ->first();

        $sprintPR = $user->personalRecords()
            ->with(['exercise'])
            ->whereHas('exercise', function ($query) {
                $query->where('name', 'like', '%40 Yard Dash%');
            })
            ->where('record_type', 'TIME_BASED')
            ->latest()
            ->first();

        $verticalLeapPR = $user->personalRecords()
            ->with(['exercise'])
            ->whereHas('exercise', function ($query) {
                $query->where('name', 'like', '%Vertical Leap%');
            })
            ->where('record_type', 'HEIGHT_BASED')
            ->latest()
            ->first();

        $agilityPR = $user->personalRecords()
            ->with(['exercise'])
            ->whereHas('exercise', function ($query) {
                $query->where('name', 'like', '%Agility%');
            })
            ->where('record_type', 'TIME_BASED')
            ->latest()
            ->first();

        // Calculate month-over-month changes
        $monthlyChanges = $this->calculateMonthlyChanges($user);

        return view('dashboard', compact(
            'hasData',
            'benchPressPR',
            'sprintPR',
            'verticalLeapPR',
            'agilityPR',
            'monthlyChanges'
        ));
    }

    protected function hasUserData($userId)
    {
        return PersonalRecord::where('user_id', $userId)->exists();
    }

    protected function calculateMonthlyChanges($user)
    {
        $changes = [];
        $lastMonth = Carbon::now()->subMonth();
        $thisMonth = Carbon::now();

        // Get PRs from last month
        $lastMonthPRs = $user->personalRecords()
            ->whereBetween('achieved_at', [$lastMonth->startOfMonth(), $lastMonth->endOfMonth()])
            ->get();

        // Get PRs from this month
        $thisMonthPRs = $user->personalRecords()
            ->whereBetween('achieved_at', [$thisMonth->startOfMonth(), $thisMonth->endOfMonth()])
            ->get();

        // Calculate changes for each exercise type
        foreach ($thisMonthPRs as $pr) {
            $lastMonthPR = $lastMonthPRs->where('exercise_id', $pr->exercise_id)
                ->where('record_type', $pr->record_type)
                ->first();

            if ($lastMonthPR) {
                $changes[$pr->exercise_id] = [
                    'value' => $pr->calculated_value - $lastMonthPR->calculated_value,
                    'type' => $pr->record_type,
                    'unit' => $pr->unit
                ];
            }
        }

        return $changes;
    }
} 