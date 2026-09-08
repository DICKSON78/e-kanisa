<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('follow_up_type'); // Kutokuwepo, Mtihani, Shida ya Kiafya, Nyingine
            $table->string('priority')->default('Ya Kawaida'); // Ya Dharura, Ya Juu, Ya Kawaida
            $table->string('status')->default('Inasubiri'); // Inasubiri, Imeanzishwa, Imekamilika
            $table->string('subject');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('last_contact_date')->nullable();
            $table->date('follow_up_date')->nullable(); // Next follow-up date
            $table->text('action_taken')->nullable();
            $table->text('outcome')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('follow_up_type');
            $table->index('priority');
            $table->index('follow_up_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_followups');
    }
};
