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
        Schema::create('conferences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->default('ICT Commission Event');
            $table->integer('conferenceYear');
            $table->string('startDate');
            $table->string('endDate');
            $table->string('venue');
            $table->string('theme');
            $table->longText('aboutConference');
            $table->integer('defaultFee');
            $table->integer('foreignerFee');
            $table->integer('guestFee');
            $table->boolean('lock')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
