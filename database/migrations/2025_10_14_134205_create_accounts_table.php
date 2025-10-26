<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. 1000, 2000
            $table->string('name');           // e.g. Inventory, Cash
            $table->enum('type', ['asset', 'liability', 'equity', 'income', 'expense']);
            $table->unsignedBigInteger('admin_id')->nullable();
                        $table->unsignedBigInteger('employee_id')->nullable();

            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
