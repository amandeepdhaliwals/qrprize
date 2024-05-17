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
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming OTP is tied to a user
            $table->string('otp_code');
            $table->enum('type', ['email', 'mobile']);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('expires_at');
            $table->timestamps();

            // Adding a foreign key constraint (optional)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
