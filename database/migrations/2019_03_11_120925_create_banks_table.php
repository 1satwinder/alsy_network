<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('upi_id')->nullable();
            $table->string('upi_number')->nullable();
            $table->string('company_payment_department')->nullable();
            $table->string('name');
            $table->string('branch_name');
            $table->string('account_holder_name');
            $table->string('ac_number');
            $table->string('ifsc');
            $table->integer('ac_type')->comment('1:saving,2:current');
            $table->integer('status')->default('1')->comment('1:active,2:inactive');
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
        Schema::dropIfExists('banks');
    }
}
