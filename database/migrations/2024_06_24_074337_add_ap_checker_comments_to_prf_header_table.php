<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApCheckerCommentsToPrfHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prf_header', function (Blueprint $table) {
            $table->unsignedInteger('ap_supervisor')->nullable()->after('validated_at');
            $table->date('supervisor_approval_date')->nullable()->after('ap_supervisor');
            $table->date('transmittal_date')->nullable()->after('supervisor_approval_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prf_header', function (Blueprint $table) {
            $table->dropColumn('ap_supervisor');
            $table->dropColumn('supervisor_approval_date');
            $table->dropColumn('transmittal_date');
        });
    }
}
