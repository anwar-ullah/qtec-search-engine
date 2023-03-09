<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Menu extends Migration
{
    public function up()
    {
        Schema::dropIfExists('menu');
        
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('module_id')->unsigned();
            $table->string('name');
            $table->text('route');
            $table->text('icon')->nullable();
            $table->text('desc')->nullable();
            $table->integer('serial')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
