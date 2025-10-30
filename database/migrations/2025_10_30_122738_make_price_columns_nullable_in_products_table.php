<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('purchase_price', 15, 2)->nullable()->change();
            $table->decimal('price', 15, 2)->nullable()->change();
        });
    }

    // public function down(): void
    // {
    //     Schema::table('products', function (Blueprint $table) {
    //         $table->decimal('purchase_price', 15, 2)->nullable(false)->change();
    //         $table->decimal('price', 15, 2)->nullable(false)->change();
    //     });
    // }
};
