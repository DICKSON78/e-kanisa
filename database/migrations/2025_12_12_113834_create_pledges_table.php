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
        Schema::create('pledges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('pledge_type'); // e.g., 'Kiwanja 2025', 'Usiku wa Agape', 'Mavuno 2025'
            $table->decimal('amount', 15, 2); // Total pledge amount
            $table->decimal('amount_paid', 15, 2)->default(0); // Amount paid so far
            $table->date('pledge_date'); // Date when pledge was made
            $table->date('due_date')->nullable(); // Expected completion date
            $table->enum('status', ['Pending', 'Partial', 'Completed'])->default('Pending');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pledges');
    }
};
