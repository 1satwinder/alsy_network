<?php

use App\Models\PinRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePinRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pin_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->integer('no_pins');
            $table->string('payment_mode')->nullable();
            $table->string('reference_no')->nullable();
            $table->dateTime('deposit_date')->nullable();
            $table->tinyInteger('status')
                ->comment('1: Pending, 2: Approved, 3: Reject')
                ->default(PinRequest::STATUS_PENDING)
                ->index();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pin_requests');
    }
}
