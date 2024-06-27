<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApCheckerDateRecorderToPrePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_payment', function (Blueprint $table) {
            $table->date('ap_checker_date_recorded')->nullable()->after('ap_checker_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_payment', function (Blueprint $table) {
            $table->dropColumn('ap_checker_date_recorded');
        });
    }
}
