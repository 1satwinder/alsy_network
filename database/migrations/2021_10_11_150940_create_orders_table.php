<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->integer('pincode');
            $table->string('order_no')->nullable()->index();
            $table->string('transaction_id')->nullable()->index();
            $table->string('invoice_no')->nullable();
            $table->unsignedInteger('total_items')->default(0);
            $table->unsignedInteger('total_quantity')->default(0);
            $table->decimal('total_mrp', 20)->default(0)->nullable();
            $table->decimal('total_bv', 20)->default(0)->nullable();
            $table->decimal('total_dp', 20)->default(0)->nullable();
            $table->decimal('total_taxable_value', 20)->default(0);
            $table->decimal('total_discount', 20)->default(0);
            $table->decimal('total_sgst_amount', 20)->default(0)->nullable();
            $table->decimal('total_cgst_amount', 20)->default(0)->nullable();
            $table->decimal('total_igst_amount', 20)->default(0)->nullable();
            $table->decimal('total_gst_amount', 20)->default(0);
            $table->decimal('amount')->default(0);
            $table->decimal('cart_amount')->default(0);
            $table->decimal('wallet')->default(0);
            $table->decimal('total', 20)->default(0);
            $table->decimal('shipping_charge')->default(0);
            $table->longText('gst_details')->nullable();
            $table->string('comment')->nullable();
            $table->string('courier_partner')->index()->nullable();
            $table->string('courier_awb')->index()->nullable();
            $table->string('courier_tracking_url')->nullable();
            $table->smallInteger('type')
                ->comment('1: Customer')
                ->default(Order::TYPE_CUSTOMER)
                ->index();
            $table->smallInteger('pay_by')->comment('1: Online, 2: COD, 3: Wallet')->index();
            $table->smallInteger('status')->default(Order::STATUS_IN_CHECKOUT)->index();
            $table->smallInteger('payment_status')
                ->default(Order::PAYMENT_IN_CHECKOUT)
                ->comment('1: In-Checkout, 2: Capture, 3: Authorized, 4: Fail')->index();
            $table->longText('admin_address')->nullable();
            $table->longText('admin_city')->nullable();
            $table->longText('admin_state')->nullable();
            $table->string('admin_pincode')->nullable();
            $table->string('admin_mobile')->nullable();
            $table->string('admin_email')->nullable();
            $table->integer('is_income_given')->default(false);
            $table->longText('response')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
