<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('event_type')->nullable(); // Linked to event type
            $table->date('media_date');
            $table->string('status')->default('Published'); // Draft, Published, Archived
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('media_date');
        });

        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('media_galleries')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type'); // image, video, document
            $table->integer('file_size')->nullable(); // in bytes
            $table->string('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('gallery_id');
            $table->index('file_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_items');
        Schema::dropIfExists('media_galleries');
    }
};
