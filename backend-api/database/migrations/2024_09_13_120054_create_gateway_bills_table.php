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
        Schema::create('gateway_bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('description');
            $table->string('uuid');
            $table->string('phone_number');
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('approved_by');
            $table->decimal('amount', 10, 2);
            $table->string('ccy', 3);
            $table->integer('payment_option');
            $table->integer('status_code')->nullable();
            $table->timestamp('expires_at');
            $table->integer('payment_order_id');
            $table->string('flag')->nullable();
            $table->boolean('status')->default(false);
            $table->string('bill_id')->nullable();
            $table->string('system_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_bills');
    }
};
