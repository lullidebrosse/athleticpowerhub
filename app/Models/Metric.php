<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'metric_type',
        'load',
        'reps',
        'sets',
        'duration',
        'distance',
        'height',
        'speed',
        'notes',
        'performed_at'
    ];

    protected $casts = [
        'load' => 'decimal:2',
        'duration' => 'decimal:2',
        'distance' => 'decimal:2',
        'height' => 'decimal:2',
        'speed' => 'decimal:2',
        'performed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function personalRecords()
    {
        return $this->hasMany(PersonalRecord::class);
    }

    // Helper method to calculate the value based on metric type
    public function calculateValue()
    {
        return match($this->metric_type) {
            'MAX_WEIGHT' => $this->load,
            'REP_MAX' => $this->load * (36 / (37 - $this->reps)), // Brzycki Formula
            'DENSITY' => ($this->load * $this->reps * $this->sets) / $this->duration,
            'TIME' => $this->duration,
            'DISTANCE' => $this->distance,
            'HEIGHT' => $this->height,
            'SPEED' => $this->speed,
            default => null
        };
    }
} 