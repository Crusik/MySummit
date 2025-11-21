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
        Schema::disableForeignKeyConstraints();

        Schema::create('lab_results', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('user_id') -> constrained('users') -> onDelete('cascade');
            $table -> string('test_name');
            $table -> text('description') -> nullable();
            $table -> string('test_type'); // e.g., 'blood_work', 'imaging', 'screening'
            $table -> dateTime('test_date');
            $table -> dateTime('results_received_date') -> nullable();
            $table -> string('status') -> default('pending'); // pending, completed, reviewed
            $table -> text('result_value') -> nullable();
            $table -> string('unit') -> nullable();
            $table -> string('reference_range') -> nullable();
            $table -> text('provider_notes') -> nullable();
            $table -> string('file_path') -> nullable(); // path to PDF/document
            $table -> timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};
