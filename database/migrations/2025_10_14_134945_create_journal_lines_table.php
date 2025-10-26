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
       Schema::create('journal_lines', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('journal_entry_id');
    $table->unsignedBigInteger('account_id');
    $table->decimal('debit', 15, 2)->default(0);
    $table->decimal('credit', 15, 2)->default(0);
    $table->timestamps();

    $table->foreign('journal_entry_id')->references('id')->on('journal_entries')->onDelete('cascade');
    $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_lines');
    }
};
