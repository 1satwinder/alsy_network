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
        Schema::create('referral_bonus_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('top_up_id')->constrained('top_ups');
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('from_member_id')->constrained('members');
            $table->decimal('total', 20);
            $table->timestamps();

            $table->unique(['top_up_id', 'member_id', 'from_member_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_bonus_incomes');
    }
};
