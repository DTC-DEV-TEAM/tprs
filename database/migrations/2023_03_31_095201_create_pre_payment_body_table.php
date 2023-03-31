<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrePaymentBodyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_payment_body', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pre_payment_id')->nullable();
            $table->string('project_name')->nullable();
            $table->integer('budget-amount')->nullable();
            $table->string('budget_category')->nullable();
            $table->string('budget_description')->nullable();
            $table->string('budget_justification')->nullable();
            $table->string('budget_location')->nullable();
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
        Schema::dropIfExists('pre_payment_body');
    }
}
