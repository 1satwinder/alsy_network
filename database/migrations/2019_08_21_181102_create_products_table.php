<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->unsignedBigInteger('g_s_t_type_id')->nullable();
            $table->string('name')->unique();
            $table->string('slug')->nullable();
            $table->string('sku')->unique();
            $table->decimal('mrp', 20);
            $table->decimal('dp', 20);
            $table->decimal('bv', 20);
            $table->decimal('opening_stock', 20);
            $table->decimal('company_stock', 20);
            $table->integer('status')
                ->comment('1: Active, 2: In-Active')
                ->default(Product::STATUS_ACTIVE);
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('g_s_t_type_id')->references('id')->on('g_s_t_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
