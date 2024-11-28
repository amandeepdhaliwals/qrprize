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
        Schema::create('campaign_ads_meta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('advertisement_id');
            $table->boolean('is_new_ad')->default(false);
            $table->boolean('is_trending_ad')->default(false);
            $table->boolean('is_ad_of_the_day')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('campaign_id')->references('id')->on('campaign')->onDelete('cascade');
            $table->foreign('advertisement_id')->references('id')->on('advertisement')->onDelete('cascade');

            // Indexes
            $table->index(['campaign_id', 'advertisement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_ads_meta');
    }
};
