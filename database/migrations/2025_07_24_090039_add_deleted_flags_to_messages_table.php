<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->boolean('deleted_for_user')->default(false);
        $table->boolean('deleted_for_admin')->default(false);
    });
}

public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropColumn(['deleted_for_user', 'deleted_for_admin']);
    });
}


    /**
     * Reverse the migrations.
     */
 
};
