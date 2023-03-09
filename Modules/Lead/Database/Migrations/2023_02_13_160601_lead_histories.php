<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeadHistories extends Migration
{
    public function up()
    {
        Schema::create('lead_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lead_id', false);
            $table->foreign('lead_id')->references('id')->on('leads')->cascadeOnDelete()->cascadeOnUpdate();

            $table->enum('status', array('new', 'hold', 'trash', 'cancelled', 'requested-for-confirmation', 'confirmed'))->default('new');
            
            $table->unsignedBigInteger('user_id', false);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lead_histories');
    }
}
