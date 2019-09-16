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
        Schema::create('orders', function(Blueprint $table){
            $table->increments('id');
            $table->integer('shopping_cart_id')->unsigned();
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_carts');
            $table->string('line1');
            $table->string('line2')->nullable(true);
            $table->string('city');
            $table->string('postal_code');
            $table->string('country_code');
            $table->string('state');
            $table->string('recipient_name'); /*Persona que será la encargada de recibir el paquete, no necesariamente el comprador*/
            $table->string('email');
            $table->string('status')->default('created');
            $table->string('guide_number')->nullable(true);
            $table->integer('total');

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
        //
    }
}
