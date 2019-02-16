<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundamentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fundamentals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('fye');
            $table->decimal('pe',12,4)->default(0);
            $table->decimal('dy',12,4)->default(0);
            $table->decimal('eps',12,4)->default(0);
            $table->decimal('dps',12,4)->default(0);
            $table->decimal('net_profit_gr',12,4)->default(0);
            $table->biginteger('share_qty')->default(0);
            $table->biginteger('total_cash')->default(0);
            $table->biginteger('short_term_loan')->default(0);
            $table->biginteger('long_term_loan')->default(0);
            $table->decimal('gearing',12,4)->default(0);
            $table->decimal('debt_equity',12,4)->default(0);
            $table->decimal('gp_cash',12,4)->default(0);
            $table->decimal('net_margin',12,4)->default(0);
            $table->decimal('roe',12,4)->default(0);
            $table->decimal('fcf_share',12,4)->default(0);
            $table->decimal('roa',12,4)->default(0);
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
        Schema::dropIfExists('fundamentals');
    }
}
