<?php

use App\Models\Payout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->bigIncrements('id');
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
            $table->integer('status')
                ->comment('1: Pending, 2: Complete')
                ->default(Payout::STATUS_PENDING)
                ->index();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('payouts');
    }
}
