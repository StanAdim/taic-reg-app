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
        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('minActivity')->nullable();
            $table->json('panelist')->nullable(); //array
            $table->string('moderator')->nullable();
            $table->boolean('hasMinActivity')->default(false);
            $table->boolean('hasPanelist')->default(false);
            $table->boolean('is_visible')->default(false);
            $table->uuid('timetable_id')
                    ->nullable()
                    ->constrained('activities')
                    ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
