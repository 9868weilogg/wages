<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGisRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gis_ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('ba1')->default(0);
            $table->integer('ba1_1')->default(0);
            $table->integer('ba1_2')->default(0);
            $table->integer('ba1_3')->default(0);
            $table->integer('ba1_4')->default(0);
            $table->integer('ba1_5')->default(0);
            $table->integer('ba2')->default(0);
            $table->integer('ba3')->default(0);
            $table->integer('ba4')->default(0);
            $table->integer('ba5')->default(0);
            $table->integer('ba6')->default(0);
            $table->integer('ba7')->default(0);
            $table->integer('fa1')->default(0);
            $table->integer('fa2')->default(0);
            $table->integer('fa3')->default(0);
            $table->integer('fa4')->default(0);
            $table->integer('fa5')->default(0);
            $table->integer('fa6')->default(0);
            $table->integer('buffett_mark')->default(0);
            $table->integer('fisher_mark')->default(0);
            $table->integer('watchlist_item_id');
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
        Schema::dropIfExists('gis_ranks');
    }
}
