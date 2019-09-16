<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->decimal('price', 2);
            $table->integer('quantity');
            $table->date('release_date')->nullable();
            $table->integer('players_num')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('platform', 30)->nullable();
            $table->string('description');
            $table->enum('type', ['console', 'videogame', 'accessory']);
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
        Schema::dropIfExists('articles');
    }
}
