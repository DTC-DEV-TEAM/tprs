<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApRecordingToPrePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_payment', function($table)
        {
            $table->integer('ap_checker_id')->nullable()->after('approver_date');
            $table->text('ap_checker_note')->nullable()->after('ap_checker_id');
            $table->timestamp('ap_checker_date')->nullable()->after('ap_checker_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_payment', function($table)
        {
            $table->dropColumn('ap_checker_id');
            $table->dropColumn('ap_checker_note');
            $table->dropColumn('ap_checker_date');
        });
    }
}