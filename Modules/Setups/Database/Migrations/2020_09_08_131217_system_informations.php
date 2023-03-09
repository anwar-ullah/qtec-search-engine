<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemInformations extends Migration
{
    public function up()
    {
        Schema::dropIfExists('system_information');
        
        Schema::create('system_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('phone');
            $table->text('mobile');
            $table->text('address');
            $table->text('email');
            $table->text('twitter');
            $table->text('facebook');
            $table->text('instagram');
            $table->text('skype');
            $table->text('linked_in');
            $table->text('logo');
            $table->text('icon');
            $table->text('report_file')->nullable();
            $table->text('report_file_info')->nullable();
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
        Schema::dropIfExists('system_information');
    }
}
