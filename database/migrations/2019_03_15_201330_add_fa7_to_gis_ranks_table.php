<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFa7ToGisRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gis_ranks', function (Blueprint $table) {
            $table->integer('fa7')->after('fa6')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gis_ranks', function (Blueprint $table) {
            $table->dropColumn('fa7');
        });
    }
}
