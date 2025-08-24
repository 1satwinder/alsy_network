<?php

use App\Models\FundRequest;
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
        Schema::create('fund_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('bank_id');
            $table->decimal('amount', 20);
            $table->string('transaction_no')->unique();
            $table->string('payment_mode')->nullable();
            $table->dateTime('deposit_date')->nullable();
            $table->tinyInteger('status')
                ->comment('1: Pending, 2: Approved, 3: Reject')
                ->default(FundRequest::STATUS_PENDING)
                ->index();
            $table->longText('remark')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_requests');
    }
};
