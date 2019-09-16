<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomIDColumnToShoppingCarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopping_carts', function(Blueprint $table){
            $table->string('customid')->nullable();     /*Al hacer la migración definiendo el customId como unique() fallaba porque el campo se creaba como VARCHAR de longitud 255, por lo que se modifica manualmente desde BD y se le aplica el indice unico luego*/
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
