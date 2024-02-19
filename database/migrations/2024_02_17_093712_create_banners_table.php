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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('image');
            $table->longText('heading_1')->nullable();
            $table->longText('heading_2')->nullable();
            $table->longText('text')->nullable();
            $table->longText('button_text')->nullable();
            $table->longText('button_link')->nullable();
            $table->string('search_key')->nullable();
            $table->string('search_value')->nullable();
            $table->string('banner_type');
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
        Schema::dropIfExists('banners');
    }
};
