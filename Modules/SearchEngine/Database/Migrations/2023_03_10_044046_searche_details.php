<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SearcheDetails extends Migration
{
    public function up()
    {
        Schema::create('search_data_models', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('search_id', false);
            $table->foreign('search_id')->references('id')->on('searches')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('data_model_id', false);
            $table->foreign('data_model_id')->references('id')->on('data_models')->cascadeOnDelete()->cascadeOnUpdate();

            $table->longText('content')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_data_models');
    }
}
