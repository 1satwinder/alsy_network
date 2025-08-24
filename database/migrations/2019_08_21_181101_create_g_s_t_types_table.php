<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGSTTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_s_t_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hsn_code');
            $table->decimal('sgst');
            $table->decimal('cgst');
            $table->decimal('gst');
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
        Schema::dropIfExists('g_s_t_types');
    }
}
