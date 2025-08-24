<?php

use App\Models\Pin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('pin_request_id')->nullable();
            $table->string('code')->unique();
            $table->decimal('amount', 20);
            $table->unsignedInteger('used_by')->nullable();
            $table->unsignedInteger('activated_by_id')->nullable();
            $table->unsignedInteger('activated_by_type')->nullable()->comment('1:admin,2:member');
            $table->timestamp('used_at')->nullable();
            $table->integer('status')->comment('0: Un Used, 1: Used')->default(Pin::STATUS_USED);
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('pin_request_id')->references('id')->on('pin_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pins');
    }
}
