<?php

use App\Models\Package;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('admin_id')->nullable()->constrained();
            $table->string('name')->unique();
            $table->decimal('amount', 20)->default(0);
            $table->decimal('referral_bonus_per', 20);
            $table->decimal('pv', 20);
            $table->integer('status')
                ->comment('1: Active, 2: In-Active')
                ->default(Package::STATUS_ACTIVE)
                ->index();
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
        Schema::dropIfExists('packages');
    }
}
