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
        Schema::create('sub_footer_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('footer_menu_id');
            $table->string('name');
            $table->string('link');
            $table->string('search_key');
            $table->string('search_value');
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
        Schema::dropIfExists('sub_footer_menus');
    }
};
