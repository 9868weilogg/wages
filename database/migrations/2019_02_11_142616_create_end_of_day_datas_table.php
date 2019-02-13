<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndOfDayDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('end_of_day_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->biginteger('volume')->nullable();
            $table->decimal('close',12,4)->nullable();
            $table->decimal('open',12,4)->nullable();
            $table->decimal('high',12,4)->nullable();
            $table->decimal('low',12,4)->nullable();
            $table->decimal('high52wk',12,4)->nullable();
            $table->decimal('low52wk',12,4)->nullable();
            $table->biginteger('market_cap')->nullable();
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
        Schema::dropIfExists('end_of_day_datas');
    }
}
