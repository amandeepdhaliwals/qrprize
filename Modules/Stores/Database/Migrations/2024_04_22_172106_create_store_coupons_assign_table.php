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
        Schema::create('store_coupons_assign', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); 
            $table->integer('qrcode_id'); 
            $table->integer('coupon_id'); 
            $table->integer('total_no_of_coupons'); 
            $table->integer('no_of_winned_coupons'); 
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
        Schema::dropIfExists('store_coupons_assign');
    }
};
