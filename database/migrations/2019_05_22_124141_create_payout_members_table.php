<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayoutMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('payout_id');
            $table->string('pan_card')->nullable();
            $table->string('aadhaar_card')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('account_type')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->decimal('amount', 20)->default(0);
            $table->decimal('tds', 20)->default(0);
            $table->decimal('admin_charge', 20)->default(0);
            $table->decimal('total', 20)->default(0);
            $table->decimal('referral_bonus_income')->default(0);
            $table->decimal('team_bonus_income')->default(0);
            $table->decimal('magic_pool_bonus_income')->default(0);
            $table->decimal('magic_pool_upgrade')->default(0);
            $table->decimal('transfer_to_fund_wallet')->index()->default(0);
            $table->decimal('admin_credit', 20)->default(0);
            $table->decimal('admin_debit', 20)->default(0);
            $table->decimal('payable_amount', 20)->default(0);
            $table->integer('status')->comment(' 1: Pending ,2: Complete')->default('1')->index();
            $table->string('comment')->nullable();

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
        Schema::dropIfExists('payout_members');
    }
}
