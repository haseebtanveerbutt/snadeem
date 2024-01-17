<?php

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

            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('shopify_order_id')->nullable();
            $table->bigInteger('shopify_fulfillment_order_id')->nullable();
            $table->text('fulfillment_tracking_id')->nullable();
            $table->string('fulfillment_tracking_status')->nullable();
            $table->text('fulfillment_tracking_message')->nullable();
            $table->text('instructions')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->string('financial_status')->nullable();
            $table->string('deliver_method')->nullable();
            $table->text('shipping_lines')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->text('customer')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->float('total_price')->nullable();
            $table->timestamp('shopify_created_at')->nullable();
            $table->timestamp('shopify_updated_at')->nullable();
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
