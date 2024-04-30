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
            $table->string('campaign_name');
            $table->integer('user_id'); 
            $table->integer('coupon_id'); 
            $table->integer('total_no_of_coupons'); 
            $table->integer('no_of_winned_coupons'); 
            $table->string('qr_code_url')->nullable();
            $table->longText('qr_code_image')->nullable();
            $table->integer('adv_video_id');
            $table->integer('primary_image_id');
            $table->json('secondary_images_id');
            $table->json('coupons_id');
            $table->integer('lock_time');
            $table->integer('winning_ratio');
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
