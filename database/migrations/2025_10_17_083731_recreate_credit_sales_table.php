<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateCreditSalesTable extends Migration
{
    public function up()
    {
        // Drop the existing table first
        Schema::dropIfExists('credit_sales');

        // Recreate the table with the updated schema
        Schema::create('credit_sales', function (Blueprint $table) {
            $table->id();

        $table->foreignId('product_id')->constrained('inventories');

            $table->string('unit'); // e.g., piece, dozen

            $table->integer('quantity');

            $table->decimal('price', 10, 2); // price per piece

            $table->integer('total_pieces'); // computed total pieces sold

            $table->decimal('expected_total', 12, 2); // total cost of sale (UGX)

            $table->decimal('amount_paid', 12, 2)->default(0); // amount paid at sale time

            $table->decimal('balance_left', 12, 2); // expected_total - amount_paid

            $table->string('customer_name');

            $table->date('sale_date'); // sale date (explicit date)

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // who processed it

            $table->enum('status', ['pending', 'paid', 'returned'])->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_sales');
    }
}
