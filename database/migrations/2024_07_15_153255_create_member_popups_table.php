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
        Schema::create('member_popups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->longText('link')->nullable();
            $table->integer('status')
                ->comment('1: Active, 2: In-Active')
                ->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_popups');
    }
};
