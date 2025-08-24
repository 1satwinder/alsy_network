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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->foreignId('admin_id')->nullable()->constrained();
            $table->foreignId('payout_id')->nullable()->constrained();
            $table->decimal('amount', 20);
            $table->decimal('admin_charge', 20);
            $table->decimal('tds', 20);
            $table->decimal('total', 20);
            $table->tinyInteger('status')->comment('1:pending,2:approve,3:reject')->index();
            $table->tinyInteger('payout_status')->default(0)->comment('0:pending,1:done')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
