<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('original_quantity')->nullable()->after('quantity');
            $table->string('original_unit')->nullable()->after('original_quantity'); // piece, dozen, carton

            $table->decimal('purchase_price_per_dozen', 12, 2)->nullable()->after('purchase_price');
            $table->decimal('selling_price_per_dozen', 12, 2)->nullable()->after('price');
            $table->decimal('purchase_price_per_carton', 12, 2)->nullable()->after('purchase_price_per_dozen');
            $table->decimal('selling_price_per_carton', 12, 2)->nullable()->after('selling_price_per_dozen');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'original_quantity',
                'original_unit',
                'purchase_price_per_dozen',
                'selling_price_per_dozen',
                'purchase_price_per_carton',
                'selling_price_per_carton',
            ]);
        });
    }
};
