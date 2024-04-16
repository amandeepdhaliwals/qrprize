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
        Schema::table('coupons', function (Blueprint $table) {
            // Add a new column 'status'
            $table->boolean('status')->default(true);
        });
    
        // Copy data from 'is_active' to 'status' using raw SQL
        DB::statement('UPDATE coupons SET status = is_active');
    
        Schema::table('coupons', function (Blueprint $table) {
            // Drop the original column 'is_active'
            $table->dropColumn('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Add back the 'is_active' column
            $table->boolean('is_active')->default(true);
        });
    
        // Copy data from 'status' to 'is_active' using raw SQL
        DB::statement('UPDATE coupons SET is_active = status');
    
        Schema::table('coupons', function (Blueprint $table) {
            // Drop the 'status' column
            $table->dropColumn('status');
        });
    }
};
