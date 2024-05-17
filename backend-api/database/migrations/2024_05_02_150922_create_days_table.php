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
        Schema::create('days', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->string('label');
            $table->boolean('is_visible')->default(false);
            $table->string('status')->default('open');
            $table->uuid('conference_id')
                    ->nullable()
                    ->constrained('days')
                    ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days');
    }
};
