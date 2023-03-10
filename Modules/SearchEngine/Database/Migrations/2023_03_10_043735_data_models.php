<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataModels extends Migration
{
    public function up()
    {
        Schema::create('data_models', function (Blueprint $table) {
            $table->id();

            $table->text('title');
            $table->longText('fine_points');
            $table->longText('content')->nullable();

            $table->integer('status')->default(1);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_models');
    }
}
