<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsNeedByDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petty_cash_header', function (Blueprint $table) {
            $table->date('need_by_date')->nullable()->after('status_id');
        });

        Schema::table('prf_header', function (Blueprint $table) {
            $table->date('need_by_date')->nullable()->after('status_id');
        });

        Schema::table('pre_payment', function (Blueprint $table) {
            $table->date('need_by_date')->nullable()->after('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petty_cash_header', function (Blueprint $table) {
            $table->dropColumn('need_by_date');
        });

        // Rollback changes for table 2
        Schema::table('prf_header', function (Blueprint $table) {
            $table->dropColumn('need_by_date');
        });

        // Rollback changes for table 3
        Schema::table('pre_payment', function (Blueprint $table) {
            $table->dropColumn('need_by_date');
        });
    }
}
