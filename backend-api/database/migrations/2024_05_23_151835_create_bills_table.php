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
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('conference_id');  // Use UUID for the foreign key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreign('conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->decimal('event_fee', 10, 2);
            $table->uuid('id')->primary();
            $table->string("reference_no")->default('');
            // $table->string("reference_no")->unique()->default('');
            $table->string("ReqId")->nullable();
            $table->string("GrpBillId")->nullable();
            $table->string("SpGrpCode")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("payee_name")->nullable();
            $table->string("billApproveBy")->nullable();
            $table->string("customer_name")->nullable();
            $table->string("name")->nullable();
            $table->string("GfsCode")->nullable();
            $table->string("tin_number")->nullable();
            $table->string("callback_url")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("account_number")->nullable();
            $table->string("billGeneratedBy")->nullable();
            $table->string("event_id")->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string("remarks")->nullable();
            $table->string("req_id")->nullable();
            $table->string("email")->nullable();
            $table->string("grp_bill_id")->nullable();
            $table->string("sp_grp_code")->nullable();
            $table->string("cust_cntr_num")->nullable();
            $table->string("entry_cnt")->nullable();
            $table->string("sp_code")->nullable();
            $table->string("bill_id")->nullable();
            $table->string("bill_ctr_num")->nullable();
            $table->string("psp_code")->nullable();
            $table->string("psp_name")->nullable();
            $table->string("trx_id")->nullable();
            $table->string("pay_ref_id")->nullable();
            $table->decimal("bill_amt", 10, 2)->nullable();
            $table->decimal("paid_amt", 10, 2)->nullable();
            $table->integer("bill_pay_opt")->nullable();
            $table->string("ccy")->nullable();
            $table->string("currency")->nullable();
            $table->decimal("rate", 10, 2)->nullable();
            $table->string("coll_acc_num")->nullable();
            $table->timestamp("trx_dt_tm")->nullable();
            $table->timestamp('bill_exp')->nullable();
            $table->string("usd_pay_chnl")->nullable();
            $table->string("trd_pty_trx_id")->nullable();
            $table->string("qt_ref_id")->nullable();
            $table->string("pyr_cell_num")->nullable();
            $table->string("pyr_email")->nullable();
            $table->string("pyr_name")->nullable();
            $table->string("rsv1")->nullable();
            $table->string("rsv2")->nullable();
            $table->string("rsv3")->nullable();
            $table->integer("status")->nullable();
            $table->string("paid_date")->nullable();
            $table->string("status_code")->nullable();
            $table->string("status_description")->nullable();
            $table->string("callback_token")->nullable();
            $table->softDeletes(); // Adds a 'deleted_at' column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
