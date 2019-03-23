<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function ($table) {
        $table->string('braintree_id')->nullable()->after('password');
        $table->string('paypal_email')->nullable()->after('password');
        $table->string('card_brand')->nullable()->after('password');
        $table->string('card_last_four')->nullable()->after('password');
        $table->timestamp('trial_ends_at')->nullable()->after('password');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function ($table) {
        $table->dropColumn('braintree_id');
        $table->dropColumn('paypal_email');
        $table->dropColumn('card_brand');
        $table->dropColumn('card_last_four');
        $table->dropColumn('trial_ends_at');
      });
    }
}
