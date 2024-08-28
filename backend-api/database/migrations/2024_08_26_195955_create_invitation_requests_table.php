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
        Schema::create('invitation_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table -> string('institutionName');
            $table -> string('po_box');
            $table -> string('region_Id');
            $table -> string('addressingTo');
            $table -> string('hostPosition');
            $table -> boolean('status')->default(false);
            $table -> string('email_to');
            $table->json('cc_To')->nullable();
            $table->json('others')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_requests');
    }
};
