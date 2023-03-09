<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentToLeadHistory extends Migration
{
    public function up()
    {
        Schema::table('lead_histories', function (Blueprint $table) {
            $table->text('comment')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('lead_histories', function (Blueprint $table) {
            $table->dropColumn([
                'comment'
            ]);
        });
    }
}
