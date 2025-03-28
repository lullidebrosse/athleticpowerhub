<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_log_id',
        'set_number',
        'reps',
        'weight',
        'weight_unit',
        'time',
        'time_unit',
        'distance',
        'distance_unit',
        'rest_duration_after_set',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array',
        'weight' => 'decimal:2',
        'time' => 'decimal:2',
        'distance' => 'decimal:2',
        'reps' => 'integer',
        'set_number' => 'integer',
        'rest_duration_after_set' => 'integer'
    ];

    public function exerciseLog()
    {
        return $this->belongsTo(ExerciseLog::class);
    }
}
