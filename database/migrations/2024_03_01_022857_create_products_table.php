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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');

            $table->string('price');
            $table->string('discounted_price')->nullable();
            $table->string('sale_price')->nullable();

            $table->string('display_image');
            $table->longText('images');

            $table->longText('short_description')->nullable();
          

            $table->boolean('is_new');
            $table->boolean('is_out_of_stock');
            $table->boolean('is_enabled');

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
        Schema::dropIfExists('products');
    }
};
