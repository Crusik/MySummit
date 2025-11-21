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

        Schema::create('health_records', function (Blueprint $table) {
            $table -> id();
            $table -> unsignedBigInteger('user_id');
            $table -> string('month');
            $table -> string('year');
            $table -> integer('systolic');
            $table -> string('systolic_level');
            $table -> integer('diastolic');
            $table -> string('diastolic_level');
            $table -> integer('respiratory_rate');
            $table -> string('respiratory_level');
            $table -> decimal('temperature', 5, 2);
            $table -> string('temperature_level');
            $table -> integer('heart_rate');
            $table -> string('heart_rate_level');
            $table -> timestamps();

            $table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};
