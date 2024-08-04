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
        Schema::create('exhibition_booths', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('size');
            $table->string('benefit');
            $table->integer('amount');
            $table->boolean('status')->default(true); #pending #process #rejected
            $table->foreignUuid('conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibition_booths');
    }
};
