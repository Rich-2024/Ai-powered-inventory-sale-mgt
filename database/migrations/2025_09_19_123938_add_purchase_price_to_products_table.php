<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       // In the migration file
Schema::table('products', function (Blueprint $table) {
    $table->decimal('purchase_price', 10, 2)->default(0);
});

    }

    /**
     * Reverse the migrations.
     */
  
};
