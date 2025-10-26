<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterStatusEnumInUsersTable extends Migration
{
    public function up()
    {
        // Update enum to include 'suspended'
        DB::statement("ALTER TABLE users MODIFY status ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active'");
    }

    public function down()
    {
        // Revert to old enum
        DB::statement("ALTER TABLE users MODIFY status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'");
    }
}
