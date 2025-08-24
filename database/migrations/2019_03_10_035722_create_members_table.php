<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->string('code')->unique()->nullable();
            $table->longText('sponsor_path')->nullable();
            $table->integer('level')->index();
            $table->integer('sponsored_count')->default(0);
            $table->decimal('fund_wallet_balance', 20)->default(0);
            $table->decimal('wallet_balance', 20)->default(0);
            $table->tinyInteger('is_paid')->default(1)->comment('1 :un paid, 2 :paid');
            $table->integer('status')
                ->comment('1: Free Member, 2: Active, 3: Block')
                ->index();
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('sponsor_id')->references('id')->on('members');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
