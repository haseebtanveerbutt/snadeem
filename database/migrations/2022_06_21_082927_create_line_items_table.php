<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_items', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('shopify_order_id')->nullable();
            $table->bigInteger('shopify_lineitem_id')->nullable();
            $table->bigInteger('variant_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('grams')->nullable();
            $table->string('sku')->nullable();
            $table->string('price')->nullable();
            $table->integer('fulfillable_quantity')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->string('fulfillment_service')->nullable();
            $table->string('fulfillment_response')->nullable();
            $table->string('variant_title')->nullable();
            $table->text('properties')->nullable();

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
        Schema::dropIfExists('line_items');
    }
}
