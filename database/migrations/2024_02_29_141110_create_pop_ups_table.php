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
        Schema::create('pop_ups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('link')->nullable();
            $table->string('search_key')->nullable();
            $table->string('search_value')->nullable();
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
        Schema::dropIfExists('pop_ups');
    }
};
