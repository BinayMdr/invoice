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
            $table->string('heading_1');
            $table->string('heading_2');
            $table->string('heading_3');
            $table->longText('text_1');
            $table->longText('text_2');
            $table->longText('text_3');
            $table->longText('top_banner');
            $table->boolean('show_lower_banner');
            $table->longText('lower_banner')->nullable();
            $table->longText('quote')->nullable();
            $table->string('author')->nullable();
            $table->string('designation')->nullable();
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
