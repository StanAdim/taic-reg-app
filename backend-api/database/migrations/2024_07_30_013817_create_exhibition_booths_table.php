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
            $table->uuid();
            $table->string('name');
            $table->string('size');
            $table->string('benefit');
            $table->string('amount');
            $table->uuid('conference_id')->constrained('exhibition_booths')->cascadeOnDelete();
            $table->enum('status', ['00', '01', '02'])->default('00'); #pending #process #rejected
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
