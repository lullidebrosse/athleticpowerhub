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
        Schema::table('personal_records', function (Blueprint $table) {
            $table->foreignId('exercise_pr_type_id')->nullable()->after('exercise_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_records', function (Blueprint $table) {
            $table->dropForeign(['exercise_pr_type_id']);
            $table->dropColumn('exercise_pr_type_id');
        });
    }
};
