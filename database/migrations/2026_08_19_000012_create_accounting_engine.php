<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Chart of Accounts (QuickBooks-style)
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_code')->unique(); // e.g., 1000, 1100, 2000
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // Asset, Liability, Equity, Revenue, Expense
            $table->string('sub_type')->nullable(); // Current Asset, Fixed Asset, Current Liability, etc.
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false); // System accounts can't be deleted
            $table->foreignId('parent_account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('sub_type');
        });

        // General Ledger / Journal Entries
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('entry_number')->unique(); // JE{YEAR}{SEQ}
            $table->date('entry_date');
            $table->string('description');
            $table->string('reference_type')->nullable(); // Income, Expense, Transfer, Payroll
            $table->foreignId('reference_id')->nullable();
            $table->string('status')->default('Draft'); // Draft, Posted, Voided
            $table->decimal('total_debit', 15, 2)->default(0);
            $table->decimal('total_credit', 15, 2)->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('posted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('posted_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('entry_date');
            $table->index('status');
            $table->index(['reference_type', 'reference_id']);
        });

        // Journal Entry Lines (double-entry bookkeeping)
        Schema::create('journal_entry_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_entry_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('account_id');
        });

        // Account Transactions (running balance tracker)
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('journal_entry_id')->constrained()->onDelete('cascade');
            $table->date('transaction_date');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['account_id', 'transaction_date']);
        });

        // Fiscal Periods
        Schema::create('fiscal_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "FY 2026"
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_closed')->default(false);
            $table->foreignId('closed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->unique(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_transactions');
        Schema::dropIfExists('journal_entry_lines');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('fiscal_periods');
        Schema::dropIfExists('accounts');
    }
};
