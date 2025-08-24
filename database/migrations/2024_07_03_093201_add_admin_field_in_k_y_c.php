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
        Schema::table('k_y_c_s', function (Blueprint $table) {
            $table->foreignId('admin_id')->nullable()->after('member_id')
                ->constrained('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_y_c_s', function (Blueprint $table) {
            $table->dropForeign('admin_id');
            $table->dropColumn('admin_id');
        });
    }
};
