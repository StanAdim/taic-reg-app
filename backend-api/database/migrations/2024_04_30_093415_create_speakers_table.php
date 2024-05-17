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
        Schema::create('speakers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('designation');
            $table->string('institution');
            $table->string('linkedinLink')->nullable();
            $table->string('twitterLink')->nullable();
            $table->string('imgPath')->default('/speakers/placeholder.png');
            $table->boolean('isMain')->default(false);
            $table->uuid('conference_id')->nullable()
                    ->constrained('speakers')->cascadeOnDelete();
            $table->boolean('is_visible')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
