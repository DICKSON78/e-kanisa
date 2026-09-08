<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique(); // TRF{YEAR}{SEQ}
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('transfer_type'); // Kuingia (Transfer In), Kutoka (Transfer Out)
            $table->string('from_church')->nullable(); // Source church for transfer in
            $table->string('to_church')->nullable(); // Destination church for transfer out
            $table->string('from_pastor')->nullable(); // Pastor at source church
            $table->string('to_pastor')->nullable(); // Pastor at destination church
            $table->date('transfer_date');
            $table->string('reason')->nullable();
            $table->string('status')->default('Inasubiri'); // Inasubiri, Imeidhinishwa, Imekataliwa
            $table->text('notes')->nullable();
            $table->text('documents')->nullable(); // JSON array of document paths
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('transfer_type');
            $table->index('status');
            $table->index('transfer_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_transfers');
    }
};
