<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date');
            $table->string('service_type')->default('Ibada Kuu'); // Ibada Kuu, Ibada ya Jumapili, Kikao, Nyingine
            $table->string('status')->default('Hudhuria'); // Hudhuria, Kuchukuliwa, Kutohudhuria
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['member_id', 'attendance_date', 'service_type']);
            $table->index('attendance_date');
            $table->index('service_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
