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
        Schema::create('app_site_information', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('type'); // Type of information: 'about_us', 'privacy_policy', 'help_support'
            $table->text('content')->nullable(); // Content of About Us or Privacy Policy
            $table->string('mobile')->nullable(); // Help & Support mobile
            $table->string('email')->nullable(); // Help & Support email
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_site_information');
    }
};
