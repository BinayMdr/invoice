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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('image');
            $table->longText('heading_1')->nullable();
            $table->longText('text_1')->nullable();
            $table->longText('text_2')->nullable();
            $table->longText('text_3')->nullable();
            $table->longText('button_text')->nullable();
            $table->longText('button_link')->nullable();
            $table->string('search_key')->nullable();
            $table->string('search_value')->nullable();
            $table->string('offer_till_date');
            $table->string('sale_price');
            $table->boolean('is_enabled');
            $table->boolean('show_search');
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
        Schema::dropIfExists('sale_products');
    }
};
