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
        Schema::create('book_copy', function (Blueprint $table) {
            $table->id();
            $table->string('year_published');
            $table->foreignId('catalogue_entry_id');
            $table->foreignId('publisher_id');
            $table->timestamps();

            $table->foreign('catalogue_entry_id')->references('id')->on('catalogue_entry')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publisher')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copy');
    }
};