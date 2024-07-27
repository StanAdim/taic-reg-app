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
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->string("DateOfRegistration");
            $table->string("RegNo")->unique();
            $table->string("Name");
            $table->string("Employer");
            $table->integer("ProfessionalCategory");
            $table->string("AreaOfSpecialization");
            $table->string("Email");
            $table->string("Mobile");
            $table->string("Gender");
            $table->string("Region");
            $table->boolean("isVerified")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professionals');
    }
};
