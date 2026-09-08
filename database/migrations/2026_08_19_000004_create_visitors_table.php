<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_number')->unique(); // VIS{YEAR}{SEQ}
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('church_from')->nullable(); // Church they came from
            $table->date('visit_date');
            $table->string('service_type')->default('Ibada Kuu'); // Service type attended
            $table->string('status')->default('Mgeni wa Kwanza'); // Mgeni wa Kwanza, Anarudi, Amehama
            $table->string('referred_by')->nullable(); // Who referred them
            $table->text('notes')->nullable();
            $table->string('follow_up_status')->default('Inasubiri'); // Inasubiri, Imefanyiwa, Imekamilika
            $table->text('follow_up_notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('visit_date');
            $table->index('status');
            $table->index('follow_up_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
