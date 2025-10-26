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
       Schema::create('journal_entries', function (Blueprint $table) {
    $table->id();
    $table->string('reference')->nullable(); // e.g. 'SALE-0001'
    $table->string('description');
    $table->date('entry_date');
    $table->unsignedBigInteger('admin_id')->nullable();
    $table->timestamps();

    $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
