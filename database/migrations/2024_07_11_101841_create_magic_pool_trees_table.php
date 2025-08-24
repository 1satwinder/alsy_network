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
        Schema::create('magic_pool_trees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magic_pool_id')->constrained('magic_pools');
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('parent_id')->nullable()->constrained('magic_pool_trees');
            $table->longText('path')->nullable();
            $table->integer('level');
            $table->integer('position');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magic_pool_trees');
    }
};
