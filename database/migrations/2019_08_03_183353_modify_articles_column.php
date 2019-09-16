<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyArticlesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) { 
            $table->string('type', 15);    //Tras eliminar el campo type de tipo ENUM ya que daba error al migrar, lo volvemos a crear como VARCHAR
            $table->decimal('assesment', 3, 2);
            $table->integer('transaction_id')->unsigned()->index();
            $table->integer('score_id')->unsigned()->index();
            $table->text('description')->change();
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
