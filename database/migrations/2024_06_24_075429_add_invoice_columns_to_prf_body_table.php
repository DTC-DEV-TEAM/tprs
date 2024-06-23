<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceColumnsToPrfBodyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prf_body', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('currency_id');
            $table->date('invoice_date')->nullable()->after('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prf_body', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
            $table->dropColumn('invoice_date');
        });
    }
}
