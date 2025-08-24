<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repurchase_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id');
            $table->string('transaction_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('transport')->nullable();
            $table->unsignedInteger('total_items')->default(0);
            $table->unsignedInteger('total_quantity')->default(0);
            $table->decimal('total_bp', 20)->default(0);
            $table->decimal('total_taxable_value', 20)->default(0);
            $table->decimal('total_discount', 20)->default(0);
            $table->decimal('total_sgst_amount', 20)->default(0)->nullable();
            $table->decimal('total_cgst_amount', 20)->default(0)->nullable();
            $table->decimal('total_igst_amount', 20)->default(0)->nullable();
            $table->decimal('total_gst_amount', 20)->default(0);
            $table->decimal('total', 20)->default(0);
            $table->longText('gst_details');
            $table->string('comment')->nullable();
            $table->tinyInteger('payment_mode')
                ->comment('1. Cash, 2. DD/Cheque, 3. NEFT/RTGS');
            $table->tinyInteger('status')
                ->comment('1. Buy, 2. Refund, 3. Repurchase');
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repurchase_invoices');
    }
}
