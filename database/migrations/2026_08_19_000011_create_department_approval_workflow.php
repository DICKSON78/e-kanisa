<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Department Money Approvals (multi-level)
        Schema::create('department_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('approval_number')->unique(); // DAP{YEAR}{SEQ}
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount_requested', 15, 2);
            $table->decimal('amount_approved', 15, 2)->nullable();
            $table->string('expense_purpose')->nullable(); // What the money is for
            $table->string('priority')->default('Ya Kawaida'); // Ya Dharura, Ya Juu, Ya Kawaida
            $table->string('status')->default('Inasubiri'); // Inasubiri, Mapitio ya Mhasibu, Imeidhinishwa na Mchungaji, Imekataliwa, Imekamilika
            $table->integer('current_level')->default(1);
            $table->integer('max_level')->default(2);
            $table->text('rejection_reason')->nullable();
            $table->date('requested_date');
            $table->date('approved_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('department_id');
            $table->index('priority');
        });

        // Approval Steps (individual level approvals with digital signatures)
        Schema::create('approval_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_id')->nullable()->constrained('department_approvals')->onDelete('cascade');
            $table->integer('level'); // 1, 2, 3, etc.
            $table->string('role_required'); // Mhasibu, Mchungaji, etc.
            $table->foreignId('approver_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('decision')->nullable(); // approved, rejected
            $table->text('comments')->nullable();
            $table->string('digital_signature_hash')->nullable(); // SHA-256 hash
            $table->string('signature_path')->nullable(); // Copy of signature image
            $table->string('ip_address')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->boolean('otp_verified')->default(false);
            $table->timestamp('acted_at')->nullable();
            $table->timestamps();

            $table->index(['approval_id', 'level']);
            $table->index('decision');
        });

        // Approval Thresholds (configurable per amount range)
        Schema::create('approval_thresholds', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_amount', 15, 2);
            $table->decimal('max_amount', 15, 2)->nullable();
            $table->json('required_roles'); // ['Mhasibu', 'Mchungaji']
            $table->integer('expected_hours')->default(48);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_steps');
        Schema::dropIfExists('approval_thresholds');
        Schema::dropIfExists('department_approvals');
    }
};
