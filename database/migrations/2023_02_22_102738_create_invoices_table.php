<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->integer('customer_id');
            $table->string('sub_total');
            $table->string('discount_percent');
            $table->string('discount_amount');
            $table->string('total');
            $table->string('received_amount');
            $table->string('changed_amount');
            $table->integer('payment_method_id');
            $table->string('prepared_by_id');
            $table->string('status');
            $table->string('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
