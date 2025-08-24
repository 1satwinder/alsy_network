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
        Schema::create('member_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->unique()->constrained();
            $table->decimal('referral_bonus_income')->index()->default(0);
            $table->decimal('team_bonus_income')->index()->default(0);
            $table->decimal('magic_pool_bonus_income')->index()->default(0);
            $table->decimal('admin_credit')->index()->default(0);
            $table->decimal('all_income')->index()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_stats');
    }
};
