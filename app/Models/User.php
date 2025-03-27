<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function metrics()
    {
        return $this->hasMany(Metric::class);
    }

    public function personalRecords()
    {
        return $this->hasMany(PersonalRecord::class);
    }

    // Helper method to get the latest PR for a specific exercise and record type
    public function getLatestPR($exerciseId, $recordType)
    {
        return $this->personalRecords()
            ->where('exercise_id', $exerciseId)
            ->where('record_type', $recordType)
            ->latest()
            ->first();
    }

    // Helper method to get all PRs for a specific exercise
    public function getExercisePRs($exerciseId)
    {
        return $this->personalRecords()
            ->where('exercise_id', $exerciseId)
            ->orderBy('achieved_at', 'desc')
            ->get();
    }
}
