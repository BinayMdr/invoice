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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('heading');

            $table->string('sub_heading_1')->nullable();
            $table->longText('text_1')->nullable();
            $table->string('image_1')->nullable();
            $table->string('sub_heading_2')->nullable();
            $table->string('image_2')->nullable();
            $table->longText('text_2')->nullable();
            $table->string('sub_heading_3')->nullable();
            $table->string('image_3')->nullable();
            $table->longText('text_3')->nullable();
            $table->string('sub_heading_4')->nullable();
            $table->string('image_4')->nullable();
            $table->longText('text_4')->nullable();

            $table->string('heading_1')->nullable();
            $table->longText('sub_text')->nullable();

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
        Schema::dropIfExists('about_us');
    }
};
