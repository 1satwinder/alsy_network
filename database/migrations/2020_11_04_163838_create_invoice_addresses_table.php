<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('top_up_id');
            $table->unsignedBigInteger('member_id');
            $table->string('name');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->longText('member_address')->nullable();
            $table->string('member_email')->nullable();
            $table->string('member_mobile')->nullable();
            $table->integer('member_pincode')->nullable();
            $table->longText('admin_address')->nullable();
            $table->longText('admin_city')->nullable();
            $table->longText('admin_state')->nullable();
            $table->string('admin_pincode')->nullable();
            $table->string('admin_mobile')->nullable();
            $table->string('admin_email')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('top_up_id')->references('id')->on('top_ups');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_addresses');
    }
}
