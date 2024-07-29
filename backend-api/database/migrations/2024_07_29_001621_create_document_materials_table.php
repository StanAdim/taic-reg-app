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
        Schema::create('document_materials', function (Blueprint $table) {
            $table->uuid('uid')->unique();
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->string('file_name');
            $table->string('user_id');
            $table->integer('status')->default(1); #0 #1 #2
            $table->foreignUuid('conference_id'); // Foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_materials');
    }
};
