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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_time')->default(today());
            $table->timestamp('end_time')->default(today());
            $table->boolean('is_returned');
            $table->foreignId('book_copy_id');
            $table->foreignId('patron_id');
            $table->foreignId('staff_id');
            $table->timestamps();

            $table->foreign('book_copy_id')->references('id')->on('book_copies')->onDelete('cascade');
            $table->foreign('patron_id')->references('id')->on('patrons')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
