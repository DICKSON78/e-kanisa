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
        Schema::table('members', function (Blueprint $table) {
            // Envelope number - critical for offering tracking
            $table->string('envelope_number')->unique()->nullable()->after('member_number');

            // Spouse information
            $table->string('spouse_name')->nullable()->after('marital_status');
            $table->string('spouse_phone')->nullable()->after('spouse_name');

            // Children/Dependents information
            $table->text('children_info')->nullable()->after('spouse_phone')->comment('JSON field for children names and ages');

            // Detailed address information
            $table->string('house_number')->nullable()->after('address');
            $table->string('block_number')->nullable()->after('house_number');

            // Neighbor reference
            $table->string('neighbor_name')->nullable()->after('block_number');
            $table->string('neighbor_phone')->nullable()->after('neighbor_name');

            // Church information
            $table->string('church_elder')->nullable()->after('neighbor_phone');
            $table->string('pledge_number')->nullable()->after('church_elder');

            // Ministry/Group participation (stored as JSON array)
            $table->text('ministry_groups')->nullable()->after('special_group')->comment('JSON array of ministries: Kwaya, Fellowship, etc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'envelope_number',
                'spouse_name',
                'spouse_phone',
                'children_info',
                'house_number',
                'block_number',
                'neighbor_name',
                'neighbor_phone',
                'church_elder',
                'pledge_number',
                'ministry_groups'
            ]);
        });
    }
};
