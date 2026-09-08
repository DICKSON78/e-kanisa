<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Watoto Chini ya Miaka 5", "Sunday School - Darasa la 1"
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('age_min')->nullable(); // Minimum age
            $table->string('age_max')->nullable(); // Maximum age
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('children_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('children_classes')->onDelete('cascade');
            $table->string('status')->default('Active'); // Active, Graduated, Inactive
            $table->date('enrollment_date');
            $table->date('graduation_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['member_id', 'class_id']);
        });

        Schema::create('children_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('children_classes')->onDelete('cascade');
            $table->string('role')->default('Mwalimu'); // Mwalimu, Msaidizi, Kiongozi
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['member_id', 'class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children_teachers');
        Schema::dropIfExists('children_students');
        Schema::dropIfExists('children_classes');
    }
};
