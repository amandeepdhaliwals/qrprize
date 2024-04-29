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
        Schema::create('store_qrcodes', function (Blueprint $table) {
            $table->id();   
            $table->integer('user_id'); 
            $table->integer('adv_video_id');  
            $table->string('adv_heading')->nullable();
            $table->integer('adv_primary_image_id');  
            $table->json('adv_secondary_image_ids')->nullable();
            $table->integer('step_completed')->unsigned()->nullable();
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
        Schema::dropIfExists('store_qrcodes');
    }
};
