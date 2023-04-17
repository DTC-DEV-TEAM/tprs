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
            $table->string('description')->nullable();
            $table->integer('brand')->nullable();
            $table->integer('location')->nullable();
            $table->integer('category')->nullable();
            $table->integer('account')->nullable();
            $table->integer('currency')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('value')->nullable();
            $table->integer('amount')->nullable();
            $table->string('budget_justification')->nullable();
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
