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
        Schema::create('exhibition_requests', function (Blueprint $table) {
            $table->uuid();
            $table->integer('number' );
            $table->string('companyEmail');
            $table->string('companyName');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message')->nullable();
            $table->enum('status', ['00', '01', '02'])->default('00'); #pending #process #rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibition_requests');
    }
};
