<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('payout_member_id')->nullable();
            $table->integer('responsible_id');
            $table->string('responsible_type');
            $table->decimal('opening_balance', 20);
            $table->decimal('closing_balance', 20);
            $table->decimal('amount', 20);
            $table->decimal('tds', 20);
            $table->decimal('admin_charge', 20);
            $table->decimal('total', 20);
            $table->tinyInteger('type')->comment('1: Credit, 2: Debit')->index();
            $table->longText('comment')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('payout_member_id')->references('id')->on('payout_members');
            $table->index(['responsible_id', 'responsible_type'], 'responsible_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
