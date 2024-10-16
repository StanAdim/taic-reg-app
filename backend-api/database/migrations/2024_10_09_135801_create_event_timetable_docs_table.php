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
        Schema::create('event_timetable_docs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('path');
            $table->string('file_name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('status')->default(1); #0 #1 #2
            $table->uuid('conference_id');
            $table->foreign('conference_id')->references('id')->on('conferences')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_timetable_docs');
    }
};
