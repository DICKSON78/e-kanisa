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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('department'); // Idara inayoomba
            $table->decimal('amount_requested', 15, 2);
            $table->decimal('amount_approved', 15, 2)->nullable();
            $table->enum('status', ['Inasubiri', 'Imeidhinishwa', 'Imekataliwa'])->default('Inasubiri');
            $table->text('approval_notes')->nullable();
            $table->date('requested_date');
            $table->date('approved_date')->nullable();
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
