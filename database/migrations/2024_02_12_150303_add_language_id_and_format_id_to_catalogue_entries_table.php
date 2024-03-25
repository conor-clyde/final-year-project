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
        Schema::table('book_copies', function (Blueprint $table) {
            $table->foreignId('language_id')->nullable();
            $table->foreignId('format_id')->nullable();

            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('format_id')->references('id')->on('formats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_copies', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropForeign(['format_id']);

            $table->dropColumn('language_id');
            $table->dropColumn('format_id');
        });
    }
};
