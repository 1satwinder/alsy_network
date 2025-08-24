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
        Schema::create('magic_pools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('level');
            $table->integer('total_member');
            $table->integer('total_income');
            $table->integer('upgrade_amount');
            $table->integer('net_income');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magic_pools');
    }
};
