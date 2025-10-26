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
    Schema::create('inventories', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->unique();
        $table->string('name');
        $table->integer('quantity');
        $table->string('unit'); // 'piece', 'dozen', 'carton'
        $table->decimal('purchase_price_bulk', 15, 2)->nullable();
        $table->decimal('selling_price_bulk', 15, 2)->nullable();
        $table->decimal('purchase_price', 15, 2);
        $table->decimal('price', 15, 2);
        $table->unsignedBigInteger('admin_id');
        $table->timestamps();

        // Foreign key constraint (assumes there's an 'admins' table with 'id' as PK)
        $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
