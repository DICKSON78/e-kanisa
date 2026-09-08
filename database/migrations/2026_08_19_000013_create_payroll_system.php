<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Payroll Periods
        Schema::create('payroll_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Januari 2026"
            $table->integer('month');
            $table->integer('year');
            $table->string('status')->default('Draft'); // Draft, Processing, Completed, Paid
            $table->decimal('total_gross', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('total_net', 15, 2)->default(0);
            $table->date('pay_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['month', 'year']);
        });

        // Employee Salary Structure
        Schema::create('salary_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->decimal('basic_salary', 15, 2);
            $table->decimal('allowance_housing', 15, 2)->default(0);
            $table->decimal('allowance_transport', 15, 2)->default(0);
            $table->decimal('allowance_food', 15, 2)->default(0);
            $table->decimal('allowance_other', 15, 2)->default(0);
            $table->decimal('nssf_employee', 15, 2)->default(0);
            $table->decimal('nssf_employer', 15, 2)->default(0);
            $table->decimal('nhif_amount', 15, 2)->default(0);
            $table->decimal('paye_amount', 15, 2)->default(0);
            $table->decimal('other_deductions', 15, 2)->default(0);
            $table->string('payment_method')->default('Bank Transfer'); // Bank Transfer, Mobile Money, Cash
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('mobile_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('effective_date');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('member_id');
        });

        // Payroll Records (individual employee pay)
        Schema::create('payroll_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_period_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('salary_structure_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('basic_salary', 15, 2);
            $table->decimal('allowances', 15, 2)->default(0);
            $table->decimal('gross_salary', 15, 2);
            $table->decimal('nssf_deduction', 15, 2)->default(0);
            $table->decimal('nhif_deduction', 15, 2)->default(0);
            $table->decimal('paye_deduction', 15, 2)->default(0);
            $table->decimal('other_deductions', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('net_salary', 15, 2);
            $table->integer('days_worked')->default(30);
            $table->integer('days_absent')->default(0);
            $table->string('status')->default('Draft'); // Draft, Approved, Paid
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['payroll_period_id', 'member_id']);

            $table->index('status');
        });

        // Payroll Deductions Config
        Schema::create('payroll_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_records');
        Schema::dropIfExists('salary_structures');
        Schema::dropIfExists('payroll_configs');
        Schema::dropIfExists('payroll_periods');
    }
};
