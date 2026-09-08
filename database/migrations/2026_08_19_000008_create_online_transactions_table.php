<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique(); // TXN{YEAR}{SEQ}
            $table->foreignId('member_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->string('payment_method'); // M-Pesa, Tigo Pesa, Airtel Money, Bank Transfer
            $table->string('reference_number'); // Mobile money reference
            $table->string('phone_number')->nullable();
            $table->string('status')->default('Inasubiri'); // Inasubiri, Imekamilika, Imeshindwa, Imerejeshwa
            $table->string('purpose'); // Sadaka, Ahadi, Kodi ya Kiwanja, Nyingine
            $table->string('income_category_id')->nullable();
            $table->text('description')->nullable();
            $table->text('metadata')->nullable(); // JSON for gateway response
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('payment_method');
            $table->index('reference_number');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_transactions');
    }
};
