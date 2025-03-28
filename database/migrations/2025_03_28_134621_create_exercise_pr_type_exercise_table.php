<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercise_pr_type_exercise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_pr_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique combinations
            $table->unique(['exercise_id', 'exercise_pr_type_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercise_pr_type_exercise');
    }
}; 