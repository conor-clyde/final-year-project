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
        Schema::create('author_catalogue_entries', function (Blueprint $table) {
            $table->foreignId('author_id');
            $table->foreignId('catalogue_entry_id');

            $table->primary(['author_id', 'catalogue_entry_id']);

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('catalogue_entry_id')->references('id')->on('catalogue_entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_catalogue_entries');
    }
};
