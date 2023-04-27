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
            $table->integer('status_id')->nullable()->length(10);
            $table->integer('approver_id')->nullable();
            $table->string('approver_note')->nullable();
            $table->timestamp('approver_date')->nullable();
            $table->integer('accounting_id')->nullable();
            $table->string('accounting_note')->nullable();
            $table->timestamp('accounting_date_release')->nullable();
            $table->string('accounting_mode_of_release')->nullable();
            $table->integer('accounting_closed_by')->length(10)->nullable();
            $table->timestamp('accounting_closed_date')->nullable();
            $table->string('accounting_closed_note')->nullable();
            $table->string('department')->nullable();
            $table->string('sub_department')->nullable();
            $table->integer('department_id')->length(10)->nullable();
            $table->integer('sub_department_id')->length(10)->nullable();
            $table->string('full_name')->nullable();
            $table->string('addtional_notes')->nullable();
            $table->string('budget_information_notes')->nullable();
            $table->integer('requested_amount')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('unused_amount')->nullable();
            $table->integer('balance_amount')->nullable();
            $table->string('additional_notes')->nullable();
            $table->string('payee_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('gcash_number')->nullable();
            $table->string('system_reference_number')->nullable();
            $table->timestamp('check_date')->nullable();
            $table->string('ar_reference_number')->nullable();
            $table->timestamp('transmit_date')->nullable();
            $table->string('transmit_received_by')->nullable();
            $table->timestamp('transmit_submit_date')->nullable();
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
