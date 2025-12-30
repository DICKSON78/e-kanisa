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
        Schema::table('expenses', function (Blueprint $table) {
            // First drop the foreign key that uses the index
            $table->dropForeign('expenses_expense_category_id_foreign');
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Now we can drop the unique constraint
            $table->dropUnique('expenses_expense_category_id_year_month_unique');
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Re-add the foreign key (this will create a regular index)
            $table->foreign('expense_category_id')
                  ->references('id')
                  ->on('expense_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign('expenses_expense_category_id_foreign');
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Restore the unique constraint
            $table->unique(['expense_category_id', 'year', 'month']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Re-add the foreign key
            $table->foreign('expense_category_id')
                  ->references('id')
                  ->on('expense_categories')
                  ->onDelete('cascade');
        });
    }
};
