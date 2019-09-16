<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInShoppingCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('in_shopping_carts', function(Blueprint $table){
            $table->increments('id');

            $table->integer('article_id')->unsigned();
            $table->integer('shopping_cart_id')->unsigned();

            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('shopping_cart_id')->references('id')->on('shopping_carts');

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
        Schema::dropIfExists('in_shopping_carts');
    }
}
