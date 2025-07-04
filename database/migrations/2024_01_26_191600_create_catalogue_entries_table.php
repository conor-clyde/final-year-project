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
        Schema::create('catalogue_entries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
            $table->foreignId('genre_id');
            $table->softDeletes();

            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
           });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogue_entries');
    }
};
