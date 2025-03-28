<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'exercise_pr_type_id',
        'metric_id',
        'record_type',
        'calculated_value',
        'unit',
        'reps',
        'notes',
        'achieved_at'
    ];

    protected $casts = [
        'calculated_value' => 'decimal:2',
        'achieved_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function prType()
    {
        return $this->belongsTo(ExercisePrType::class, 'exercise_pr_type_id');
    }

    public function metric()
    {
        return $this->belongsTo(Metric::class);
    }

    // Helper method to format the record value with unit
    public function getFormattedValueAttribute()
    {
        return "{$this->calculated_value} {$this->unit}";
    }

    // Helper method to check if this is a new PR
    public function isNewRecord()
    {
        $previousRecord = static::where('user_id', $this->user_id)
            ->where('exercise_id', $this->exercise_id)
            ->where('exercise_pr_type_id', $this->exercise_pr_type_id)
            ->where('id', '!=', $this->id)
            ->latest()
            ->first();

        if (!$previousRecord) {
            return true;
        }

        return match($this->record_type) {
            'WEIGHT_BASED', 'REP_BASED' => $this->calculated_value > $previousRecord->calculated_value,
            'TIME_BASED' => $this->calculated_value < $previousRecord->calculated_value,
            'DISTANCE_BASED', 'HEIGHT_BASED' => $this->calculated_value > $previousRecord->calculated_value,
            'SPEED_BASED' => $this->calculated_value > $previousRecord->calculated_value,
            default => false
        };
    }
} 