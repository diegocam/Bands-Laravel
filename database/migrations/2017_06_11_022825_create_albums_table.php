<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('band_id')->unsigned()->index();
            $table->string('name');
            $table->date('recorded_date')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('numberoftracks')->nullable();
            $table->string('label')->nullable();
            $table->string('producer')->nullable();
            $table->string('genre')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('band_id')
                ->references('id')->on('bands')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
