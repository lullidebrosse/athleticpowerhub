<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('personal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->foreignId('metric_id')->constrained()->onDelete('cascade');
            $table->enum('record_type', ['WEIGHT_BASED', 'REP_BASED', 'TIME_BASED', 'DISTANCE_BASED', 'HEIGHT_BASED', 'SPEED_BASED']);
            $table->decimal('calculated_value', 8, 2); // The main PR value
            $table->string('unit')->nullable(); // e.g., 'lbs', 'kg', 'sec', 'm', 'in', 'mph'
            $table->integer('reps')->nullable(); // For rep-based records
            $table->text('notes')->nullable();
            $table->timestamp('achieved_at'); // When the PR was achieved
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personal_records');
    }
}; 