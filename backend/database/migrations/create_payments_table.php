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

        Schema::create('payments', function (Blueprint $table) {
            $table -> id();
            $table -> unsignedBigInteger('user_id');
            $table -> decimal('amount', 8, 2);
            $table -> string('status');
            $table -> text('description') -> nullable();
            $table -> string('payment_method') -> nullable();
            $table -> string('stripe_payment_id') -> nullable();
            $table -> timestamp('paid_at') -> nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('payments');
        Schema::enableForeignKeyConstraints();
    }
};
