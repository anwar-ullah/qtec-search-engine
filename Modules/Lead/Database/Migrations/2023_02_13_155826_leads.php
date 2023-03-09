<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Leads extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->longText('name');
            $table->longText('phone');
            $table->integer('goods_id')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->integer('leads_id')->nullable();

            $table->enum('status', array('new', 'hold', 'trash', 'cancelled', 'requested-for-confirmation', 'confirmed'))->default('new');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
