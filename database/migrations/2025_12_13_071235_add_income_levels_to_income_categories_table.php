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
        Schema::table('income_categories', function (Blueprint $table) {
            $table->decimal('target_amount', 15, 2)->nullable()->after('description');
            $table->decimal('minimum_expected', 15, 2)->nullable()->after('target_amount');
            $table->decimal('maximum_expected', 15, 2)->nullable()->after('minimum_expected');
            $table->enum('income_level', ['low', 'medium', 'high'])->default('medium')->after('maximum_expected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('income_categories', function (Blueprint $table) {
            $table->dropColumn(['target_amount', 'minimum_expected', 'maximum_expected', 'income_level']);
        });
    }
};
