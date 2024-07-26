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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('phoneNumber');
            $table->string('institution');
            $table->string('position');
            $table->boolean('professionalStatus')->default(false);
            $table->string('professionalNumber')->nullable();
            $table->string('region_id');
            $table->string('district_id');
            $table->string('notificationConsent')->default(0);
            $table->string('nation');
            $table->string('address');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
