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
        Schema::create('fund_wallet_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_member_id');
            $table->unsignedBigInteger('to_member_id');
            $table->decimal('amount', 20);
            $table->timestamps();

            $table->foreign('from_member_id')->references('id')->on('members');
            $table->foreign('to_member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_wallet_transfers');
    }
};
