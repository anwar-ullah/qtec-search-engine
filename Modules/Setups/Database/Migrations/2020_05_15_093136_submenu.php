<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Submenu extends Migration
{
    public function up()
    {
        Schema::dropIfExists('submenu');
        
        Schema::create('submenu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('menu_id')->unsigned();
            $table->string('name');
            $table->text('route');
            $table->text('icon')->nullable();
            $table->text('desc')->nullable();
            $table->integer('serial')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('submenu');
    }
}
