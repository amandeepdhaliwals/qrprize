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
        Schema::create('referral_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('referral_count'); // e.g., 5, 10, 20
            $table->string('reward_type'); // e.g., "extra_spin", "premium_draw_entry"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_milestones');
    }
};
