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
        Schema::create('customer_wins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_results_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('coupon_id');
            $table->timestamp('win_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_wins');
    }
};
