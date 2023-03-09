<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Foreignkeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu', function($table) {
           $table->foreign('module_id')->references('id')->on('modules')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('submenu', function($table) {
           $table->foreign('menu_id')->references('id')->on('menu')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('options', function($table) {
           $table->foreign('menu_id')->references('id')->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
