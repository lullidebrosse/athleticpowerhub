<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->enum('metric_type', ['MAX_WEIGHT', 'REP_MAX', 'DENSITY', 'TIME', 'DISTANCE', 'HEIGHT', 'SPEED']);
            $table->decimal('load', 8, 2)->nullable(); // Weight/resistance used
            $table->integer('reps')->nullable(); // Repetitions completed
            $table->integer('sets')->nullable(); // Number of sets completed
            $table->decimal('duration', 8, 2)->nullable(); // Time taken in seconds
            $table->decimal('distance', 8, 2)->nullable(); // Distance covered in meters
            $table->decimal('height', 8, 2)->nullable(); // Height achieved in inches/meters
            $table->decimal('speed', 8, 2)->nullable(); // Speed in mph/mps
            $table->text('notes')->nullable();
            $table->timestamp('performed_at')->nullable(); // When the exercise was performed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metrics');
    }
}; 