<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('set_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_log_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('set_number');
            $table->unsignedInteger('reps')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('weight_unit', 10)->nullable();
            $table->decimal('time', 10, 2)->nullable();
            $table->string('time_unit', 10)->nullable();
            $table->decimal('distance', 10, 2)->nullable();
            $table->string('distance_unit', 10)->nullable();
            $table->unsignedInteger('rest_duration_after_set')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamps();

            // Add index for better query performance
            $table->index('set_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_entries');
    }
};
