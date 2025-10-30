<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->nullable()->change();
            $table->decimal('purchase_price', 15, 2)->nullable()->change();
        });
    }

 
};
