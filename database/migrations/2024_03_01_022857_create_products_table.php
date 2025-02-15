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
            $table->string('price')->nullable();
            $table->string('series')->nullable();
            $table->string('reference')->nullable();
            $table->longText('image');
            $table->longText('description')->nullable();

            $table->boolean('is_enabled');
            $table->boolean('is_out_of_stock');
            $table->boolean('show_in_home_page');
            $table->integer('order');
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
