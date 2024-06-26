<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPrepaymentTable extends Migration
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
            $table->integer('printed_by')->nullable()->after('ap_checker_date');
            $table->timestamp('printed_at')->nullable()->after('printed_by');
            $table->integer('ap_supervisor_id')->nullable()->after('printed_at');
            $table->timestamp('supervisor_approval_at')->nullable()->after('ap_supervisor_id');
            $table->text('ap_supervisor_note')->nullable()->after('supervisor_approval_at');
            $table->date('ap_transmittal_date')->nullable()->after('ap_supervisor_note');
            $table->date('r_transmittal_date')->nullable()->after('ap_transmittal_date');
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
            $table->dropColumn('printed_by');
            $table->dropColumn('printed_at');
            $table->dropColumn('ap_supervisor_id');
            $table->dropColumn('supervisor_approval_at');
            $table->dropColumn('ap_supervisor_note');
            $table->dropColumn('ap_transmittal_date');
            $table->dropColumn('r_transmittal_date');
        });
    }
}