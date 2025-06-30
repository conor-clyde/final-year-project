<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Format;
use Illuminate\Support\Facades\DB;

class FormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formats')->delete();
        $formats = ['Hardcover', 'Paperback', 'Ebook', 'Audiobook'];
        foreach ($formats as $format) {
            Format::create([
                'name' => $format
            ]);
        }
    }
}
