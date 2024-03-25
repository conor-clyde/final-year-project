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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            $table->string('ISBN')->nullable();
            $table->date('publish_date');
            $table->integer('pages')->nullable();
            $table->foreignId('catalogue_entry_id');
            $table->foreignId('publisher_id');
            $table->timestamps();

            $table->foreign('catalogue_entry_id')->references('id')->on('catalogue_entries')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};
