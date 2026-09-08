<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // mapato, matumizi, kiwanja, sadaka, ahadi, custom
            $table->string('format'); // pdf, excel, csv
            $table->string('filename');
            $table->string('filepath');
            $table->string('description')->nullable();
            $table->string('period')->nullable(); // weekly, monthly, yearly, custom
            $table->string('file_size')->nullable();
            $table->json('options')->nullable(); // export options (include_logo, etc)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exports');
    }
};
