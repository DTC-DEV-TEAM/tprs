<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_number')->length(50)->nullable();
            $table->string('status_id')->nullable()->length(10);
            $table->integer('approver_id')->nullable();
            $table->string('aprrover_note')->nullable();
            $table->timestamp('approver_date')->nullable();
            $table->integer('accounting_id')->nullable();
            $table->string('accounting_note')->nullable();
            $table->integer('accounting_date')->nullable();
            $table->string('accounting_mode_of_release')->nullable();
            $table->string('requestor_receipts')->nullable();
            $table->string('department')->nullable();
            $table->string('sub_department')->nullable();
            $table->string('budget_category')->nullable();
            $table->string('budget_approval')->nullable();
            $table->enum('status', array('ACTIVE', 'INACTIVE'))->default('ACTIVE')->nullable();
            $table->integer('created_by')->length(10)->unsigned()->nullable();
            $table->integer('updated_by')->length(10)->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_payment');
    }
}
