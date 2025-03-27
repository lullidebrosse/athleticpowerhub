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

        // Get the latest metrics
        $metrics = $user->metrics()
            ->with(['exercise'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent activities (metrics) for the activity feed
        $recentActivities = $user->metrics()
            ->with(['exercise'])
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($metric) {
                $activity = [
                    'type' => 'metric',
                    'exercise' => $metric->exercise->name,
                    'date' => $metric->performed_at,
                    'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                    'icon_color' => 'indigo',
                    'message' => $this->formatActivityMessage($metric)
                ];
                return $activity;
            });

        return view('dashboard', compact('hasData', 'metrics', 'recentActivities'));
    }

    protected function hasUserData($userId)
    {
        return Metric::where('user_id', $userId)->exists();
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

    protected function formatActivityMessage($metric)
    {
        $parts = [];
        
        if ($metric->load) {
            $parts[] = "{$metric->load} lbs";
        }
        if ($metric->reps) {
            $parts[] = "{$metric->reps} reps";
        }
        if ($metric->sets) {
            $parts[] = "{$metric->sets} sets";
        }
        if ($metric->duration) {
            $parts[] = "{$metric->duration} sec";
        }
        if ($metric->distance) {
            $parts[] = "{$metric->distance} m";
        }
        if ($metric->height) {
            $parts[] = "{$metric->height} in";
        }
        if ($metric->speed) {
            $parts[] = "{$metric->speed} mph";
        }

        return "Logged {$metric->exercise->name}: " . implode(' × ', $parts);
    }
} 