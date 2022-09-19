<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('rejected')->default(0);
            $table->string('order_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('billling_address')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_full_name')->nullable();
            $table->string('card_expire')->nullable();
            $table->string('card_cvc')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('stripe_payment_info')->nullable();
            $table->double('subtotal', 8, 2)->nullable();
            $table->double('discount', 8, 2)->nullable();
            $table->double('total', 8, 2)->nullable();
            $table->string('paypal_payment_id')->nullable();
            $table->string('paypal_token')->nullable();
            $table->string('paypal_payer_id')->nullable();
            $table->dateTime('confirm_at')->nullable();
            $table->dateTime('cancel_at')->nullable();
            $table->dateTime('return_at')->nullable();
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
