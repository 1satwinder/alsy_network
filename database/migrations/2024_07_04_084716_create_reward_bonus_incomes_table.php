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
        Schema::create('reward_bonus_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_bonus_id')->constrained();
            $table->foreignId('member_id')->constrained('members');
            $table->string('reward', 255);
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_bonus_incomes');
    }
};
