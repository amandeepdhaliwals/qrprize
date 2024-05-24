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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('terms_and_condition')->nullable();
            $table->string('code')->unique();
            $table->decimal('discount')->nullable()->change();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('usage_count')->default(0);
            $table->enum('category', ['physical', 'service'])->default('physical');
            $table->unsignedInteger('total_coupons')->default(0);
            $table->unsignedInteger('no_of_assigned_coupons')->default(0);
            $table->boolean('status')->default(true);
            $table->dateTime('redemption_date')->nullable();
            $table->boolean('is_redeemed')->default(false);
            $table->string('redeemed_by')->nullable();
            $table->string('redemption_error_message')->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->json('redemption_history')->nullable();
            $table->string('redemption_location')->nullable();
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
        Schema::dropIfExists('coupons');
    }
};
