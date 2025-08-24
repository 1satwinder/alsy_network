<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_ups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('topped_up_by');
            $table->string('invoice_no')->nullable();
            $table->decimal('sgst_amount', 20)->default(0)->nullable();
            $table->decimal('cgst_amount', 20)->default(0)->nullable();
            $table->decimal('igst_amount', 20)->default(0)->nullable();
            $table->decimal('amount');
            $table->decimal('package_amount')->default(0);
            $table->decimal('gst_amount')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('topped_up_by')->references('id')->on('members');
            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_ups');
    }
}
