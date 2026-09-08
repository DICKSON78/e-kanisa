<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add signature path to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('signature_path')->nullable()->after('department_id');
        });

        // Add budget and approval fields to departments
        Schema::table('departments', function (Blueprint $table) {
            $table->decimal('annual_budget', 15, 2)->default(0)->after('description');
            $table->decimal('spent_amount', 15, 2)->default(0)->after('annual_budget');
            $table->foreignId('head_of_department')->nullable()->constrained('users')->onDelete('set null')->after('spent_amount');
            $table->string('contact_email')->nullable()->after('head_of_department');
            $table->string('contact_phone')->nullable()->after('contact_email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('signature_path');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['annual_budget', 'spent_amount', 'head_of_department', 'contact_email', 'contact_phone']);
        });
    }
};
