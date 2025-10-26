<?php

// database/migrations/xxxx_xx_xx_create_credit_sales_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditSalesTable extends Migration
{
    public function up()
    {
        Schema::create('credit_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // seller
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // owner
             $table->foreignId('employee_id')->constrained('users')->onDelete('cascade'); // owner

            $table->string('client_name');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total_amount');
            $table->enum('status', ['pending', 'paid', 'returned'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_sales');
    }
}
