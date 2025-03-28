<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        $exercises = [
            [
                'name' => 'Squat',
                'description' => 'A lower body exercise that targets the quadriceps, hamstrings, and glutes.'
            ],
            [
                'name' => 'Deadlift',
                'description' => 'A compound movement that works the posterior chain, including the lower back and hamstrings.'
            ],
            [
                'name' => 'Bench Press',
                'description' => 'A chest exercise that also engages the triceps and shoulders.'
            ],
            [
                'name' => 'Pull-ups',
                'description' => 'An upper body exercise that primarily targets the back and biceps.'
            ],
            [
                'name' => 'Push-ups',
                'description' => 'A bodyweight exercise that strengthens the chest, shoulders, and triceps.'
            ],
            [
                'name' => 'Overhead Press',
                'description' => 'A shoulder exercise that engages the deltoids and triceps.'
            ],
            [
                'name' => 'Barbell Row',
                'description' => 'An exercise targeting the upper back and biceps.'
            ],
            [
                'name' => 'Dumbbell Curl',
                'description' => 'A biceps exercise focusing on isolating the arm muscles.'
            ],
            [
                'name' => 'Tricep Dip',
                'description' => 'An exercise that targets the triceps and chest.'
            ],
            [
                'name' => 'Leg Press',
                'description' => 'A machine exercise that works the quadriceps, hamstrings, and glutes.'
            ],
            [
                'name' => 'Calf Raise',
                'description' => 'An exercise that isolates the calf muscles.'
            ],
            [
                'name' => 'Plank',
                'description' => 'A core stability exercise that strengthens the abdominal muscles.'
            ],
            [
                'name' => 'Burpees',
                'description' => 'A full-body exercise that combines strength and cardio.'
            ],
            [
                'name' => 'Lunges',
                'description' => 'A lower body exercise that targets the quadriceps and glutes.'
            ],
            [
                'name' => 'Bicep Curl',
                'description' => 'A basic exercise for building the biceps.'
            ],
            [
                'name' => 'Chest Fly',
                'description' => 'An isolation exercise that targets the chest muscles.'
            ],
            [
                'name' => 'Russian Twist',
                'description' => 'A core exercise focusing on oblique strength.'
            ],
            [
                'name' => 'Mountain Climber',
                'description' => 'A dynamic exercise that improves core stability and cardiovascular fitness.'
            ],
            [
                'name' => 'Hip Thrust',
                'description' => 'An exercise to target the glutes and hamstrings.'
            ],
            [
                'name' => 'Cable Row',
                'description' => 'A machine exercise that works the back and biceps.'
            ],
            [
                'name' => 'Cable Crossover',
                'description' => 'A chest exercise that emphasizes the inner chest muscles.'
            ],
            [
                'name' => 'Incline Bench Press',
                'description' => 'Targets the upper portion of the chest and shoulders.'
            ],
            [
                'name' => 'Decline Bench Press',
                'description' => 'Focuses on the lower chest muscles.'
            ],
            [
                'name' => 'Leg Extension',
                'description' => 'An isolation exercise for the quadriceps.'
            ],
            [
                'name' => 'Leg Curl',
                'description' => 'Targets the hamstrings through a seated or lying movement.'
            ],
            [
                'name' => 'Seated Row',
                'description' => 'A machine exercise that works the back muscles.'
            ],
            [
                'name' => 'Upright Row',
                'description' => 'Targets the shoulders and traps.'
            ],
            [
                'name' => 'Lateral Raise',
                'description' => 'Isolates the side deltoids for shoulder development.'
            ],
            [
                'name' => 'Front Raise',
                'description' => 'Focuses on the anterior deltoids.'
            ],
            [
                'name' => 'Shrugs',
                'description' => 'An exercise that strengthens the trapezius muscles.'
            ],
            [
                'name' => 'Glute Bridge',
                'description' => 'Targets the glutes and lower back.'
            ],
            [
                'name' => 'Ab Wheel Rollout',
                'description' => 'A challenging core exercise that improves abdominal strength.'
            ],
            [
                'name' => 'Medicine Ball Slam',
                'description' => 'A dynamic exercise that targets the entire body and improves power.'
            ],
            [
                'name' => 'Kettlebell Swing',
                'description' => 'A full-body exercise emphasizing the posterior chain and core.'
            ],
            [
                'name' => 'Farmer\'s Walk',
                'description' => 'A strength exercise that improves grip, core stability, and overall endurance.'
            ],
            [
                'name' => 'Sumo Squat',
                'description' => 'A variation of the squat that targets the inner thighs and glutes.'
            ],
            [
                'name' => 'Goblet Squat',
                'description' => 'A squat variation that uses a weight held close to the chest.'
            ],
            [
                'name' => 'Bulgarian Split Squat',
                'description' => 'Targets the legs individually to improve balance and strength.'
            ],
            [
                'name' => 'Pistol Squat',
                'description' => 'A challenging single-leg exercise that builds strength and balance.'
            ],
            [
                'name' => 'Box Jump',
                'description' => 'A plyometric exercise to improve power and agility.'
            ],
            [
                'name' => 'Jumping Jacks',
                'description' => 'A simple cardio exercise that elevates heart rate and burns calories.'
            ],
            [
                'name' => 'Skipping Rope',
                'description' => 'An effective cardio exercise that improves coordination and endurance.'
            ],
            [
                'name' => 'Bench Dips',
                'description' => 'A triceps exercise using body weight and a bench for support.'
            ],
            [
                'name' => 'Stability Ball Crunch',
                'description' => 'A core exercise that targets the abdominal muscles with added instability.'
            ],
            [
                'name' => 'Side Plank',
                'description' => 'An exercise that strengthens the obliques and improves core stability.'
            ],
            [
                'name' => 'V-Ups',
                'description' => 'A core exercise that targets both the upper and lower abs.'
            ],
            [
                'name' => 'Diamond Push-up',
                'description' => 'A variation of the push-up that emphasizes the triceps and inner chest.'
            ],
            [
                'name' => 'Close-Grip Bench Press',
                'description' => 'Targets the triceps and inner chest muscles.'
            ],
            [
                'name' => 'Back Extension',
                'description' => 'An exercise that strengthens the lower back and glutes.'
            ],
            [
                'name' => 'Reverse Lunge',
                'description' => 'A lower body exercise that targets the quadriceps and glutes while reducing knee stress.'
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create([ // Super admin user ID
                'name'        => $exercise['name'],
                'description' => $exercise['description'],
            ]);
        }
    }
}

