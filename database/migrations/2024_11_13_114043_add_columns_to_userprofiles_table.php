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
        Schema::table('userprofiles', function (Blueprint $table) {
            $table->json('interests')->nullable();
            $table->json('hobbies')->nullable();
            $table->string('occupation_name')->nullable();
            $table->string('college_name')->nullable();
            $table->string('specialization')->nullable();
            $table->string('url_youtube')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('userprofiles', function (Blueprint $table) {
            $table->dropColumn([
               'interests', 'hobbies', 'occupation_name', 'college_name', 'specialization','url_youtube'
            ]);
        });
    }
};
