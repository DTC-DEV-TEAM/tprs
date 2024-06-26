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
        Schema::table("prf_header", function (Blueprint $table) {
            $table->text("ap_checker_comments")->nullable()->after("approver_comments");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("prf_header", function (Blueprint $table) {
            $table->dropColumn("ap_checker_comments");
        });
    }
}
