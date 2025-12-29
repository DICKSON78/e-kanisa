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
        Schema::create('pastoral_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_number')->unique(); // Namba ya huduma (PS2025001)
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->enum('service_type', [
                'Ubatizo', // Baptism
                'Uthibitisho', // Confirmation
                'Ndoa', // Marriage
                'Wakfu', // Dedication
                'Mazishi', // Funeral
                'Ushauri wa Kichungaji', // Pastoral Counseling
                'Nyingine' // Other
            ]);
            $table->date('preferred_date')->nullable(); // Tarehe inayopendelewa
            $table->text('description')->nullable(); // Maelezo zaidi
            $table->enum('status', ['Inasubiri', 'Imeidhinishwa', 'Imekataliwa', 'Imekamilika'])
                  ->default('Inasubiri'); // Status
            $table->text('admin_notes')->nullable(); // Maoni ya admin/mchungaji
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
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
        Schema::dropIfExists('pastoral_services');
    }
};
