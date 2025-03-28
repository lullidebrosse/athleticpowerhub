<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExercisePrType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_pr_type_exercise')
            ->withTimestamps();
    }

    public function personalRecords()
    {
        return $this->hasMany(PersonalRecord::class, 'exercise_pr_type_id');
    }
}
