<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('serving_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Ibada ya Jumapili - Januari 2026"
            $table->text('description')->nullable();
            $table->date('schedule_date');
            $table->string('service_type')->default('Ibada Kuu');
            $table->string('status')->default('Active'); // Active, Completed, Cancelled
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('schedule_date');
        });

        Schema::create('serving_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('serving_schedules')->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('role'); // Mtangazaji, Mtumaji wa Madhabahu, Mwimbaji, Mtayarishaji, nk
            $table->string('position')->nullable(); // Specific position/team
            $table->string('status')->default('Imekubaliwa'); // Imekubaliwa, Inasubiri, Imekataliwa
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['schedule_id', 'member_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('serving_assignments');
        Schema::dropIfExists('serving_schedules');
    }
};
