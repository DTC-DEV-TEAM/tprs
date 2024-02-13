<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeOfPaymentInformationToPrfHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prf_header', function (Blueprint $table) {
            $table->string('cc_payee_name')->nullable()->after('gcash_number');
            $table->string('cc_last_card_number')->nullable()->after('cc_payee_name');
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prf_header', function (Blueprint $table) {
            $table->dropColumn('cc_payee_name');
            $table->dropColumn('cc_last_card_number');
        });
    }
}
