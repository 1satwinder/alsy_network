<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fund_wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id');
            $table->integer('responsible_id');
            $table->string('responsible_type');
            $table->decimal('opening_balance', 20);
            $table->decimal('closing_balance', 20);
            $table->decimal('total', 20);
            $table->tinyInteger('type')->comment('1: Credit, 2: Debit')->index();
            $table->longText('comment')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->index(['responsible_id', 'responsible_type'], 'responsible_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_wallet_transactions');
    }
};
