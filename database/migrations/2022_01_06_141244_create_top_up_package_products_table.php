<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopUpPackageProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_up_package_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('top_up_id');
            $table->unsignedBigInteger('package_product_id');
            $table->string('name');
            $table->decimal('sgst_percentage', 20)->default(0)->nullable();
            $table->decimal('cgst_percentage', 20)->default(0)->nullable();
            $table->decimal('igst_percentage', 20)->default(0)->nullable();
            $table->decimal('gst_percentage', 20)->default(0);
            $table->decimal('sgst_amount', 20)->default(0)->nullable();
            $table->decimal('cgst_amount', 20)->default(0)->nullable();
            $table->decimal('igst_amount', 20)->default(0)->nullable();
            $table->decimal('total_gst_amount', 20)->default(0)->nullable();
            $table->decimal('amount');
            $table->decimal('price');
            $table->string('hsn_code');
            $table->tinyInteger('gst_slab');
            $table->timestamps();

            $table->foreign('top_up_id')->references('id')->on('top_ups');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('package_product_id')->references('id')->on('package_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_up_package_products');
    }
}
