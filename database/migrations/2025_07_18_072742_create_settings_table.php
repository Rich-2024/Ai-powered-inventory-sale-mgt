<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('default_password');
            $table->string('shop_name');
            $table->string('shop_address');
            $table->string('shop_phone');
            $table->string('shop_email');
            $table->boolean('auto_stock_decrement')->default(true);  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
