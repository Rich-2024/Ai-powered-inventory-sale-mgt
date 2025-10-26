<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table (employee)
            $table->foreignId('employee_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Core expense fields
            $table->string('title');
            $table->decimal('amount', 10, 2);
            $table->string('category'); // e.g., transport, utilities, etc.
            $table->date('date');
            $table->text('description')->nullable();

            // Indexing for performance
            $table->index(['employee_id', 'date']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
