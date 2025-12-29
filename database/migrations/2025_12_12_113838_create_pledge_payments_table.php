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
        Schema::create('pledge_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pledge_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2); // Payment amount
            $table->date('payment_date'); // Date of payment
            $table->string('payment_method')->nullable(); // e.g., 'Cash', 'Bank Transfer', 'Mobile Money'
            $table->string('reference_number')->nullable(); // Transaction reference
            $table->string('receipt_number')->unique(); // Unique receipt number
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pledge_payments');
    }
};
