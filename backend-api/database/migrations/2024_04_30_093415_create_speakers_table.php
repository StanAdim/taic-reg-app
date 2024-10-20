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

            $table->boolean('isMain')->default(false);
            $table->string('imageFileName')->default('/speakers/placeholder.png');
            $table->uuid('conference_id')->nullable()
                    ->constrained('speakers')->cascadeOnDelete();
            $table->boolean('is_visible')->default(false);

            $table->longText('brief_bio')->nullable();
            $table->string('agenda_title')->nullable();
            $table->longText('agenda_desc')->nullable();
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
