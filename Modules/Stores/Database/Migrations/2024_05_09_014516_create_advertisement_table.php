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
        Schema::create('advertisement', function (Blueprint $table) {
            $table->id();
            $table->string('advertisement_name');
            $table->integer('store_id'); 
            $table->integer('adv_video_id'); 
            $table->string('heading')->nullable();
            $table->text('primary_image_id')->nullable();
            $table->text('secondary_images_id')->nullable();
            $table->string('other_coupon_prize_heading')->nullable();
            $table->text('other_coupon_images_id')->nullable();
            $table->json('coupons_id');
            $table->integer('total_no_of_coupons'); 
            // $table->integer('no_of_winned_coupons'); 
            //$table->integer('lock_time');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('advertisement');
    }
};
