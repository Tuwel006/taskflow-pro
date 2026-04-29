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
        Schema::table('task', function (Blueprint $table) {
            $table->unsignedInteger('task_number')->nullable()->after('id');
            // Adding a unique constraint for (project_id, task_number) to ensure no duplicates within a project
            $table->unique(['project_id', 'task_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task', function (Blueprint $table) {
            $table->dropUnique(['project_id', 'task_number']);
            $table->dropColumn('task_number');
        });
    }
};
