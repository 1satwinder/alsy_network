<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->string('order_no')->nullable()->index();
            $table->string('product_name')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('sku')->nullable();
            $table->string('category_name')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('mrp', 20)->default(0)->nullable();
            $table->decimal('dp', 20)->default(0)->nullable();
            $table->decimal('bv', 20)->default(0)->nullable();
            $table->decimal('total_mrp', 20)->default(0)->nullable();
            $table->decimal('total_dp', 20)->default(0)->nullable();
            $table->decimal('total_bv', 20)->default(0)->nullable();
            $table->decimal('taxable_value', 20)->default(0);
            $table->decimal('discount', 20)->default(0);
            $table->decimal('sgst_percentage', 20)->default(0)->nullable();
            $table->decimal('cgst_percentage', 20)->default(0)->nullable();
            $table->decimal('igst_percentage', 20)->default(0)->nullable();
            $table->decimal('gst_percentage', 20)->default(0);
            $table->decimal('sgst_amount', 20)->default(0)->nullable();
            $table->decimal('cgst_amount', 20)->default(0)->nullable();
            $table->decimal('igst_amount', 20)->default(0)->nullable();
            $table->decimal('gst_amount', 20)->default(0);
            $table->decimal('amount', 20)->default(0);
            $table->integer('quantity')->default(0);
            $table->decimal('total', 20)->default(0);
            $table->smallInteger('status')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
