<?php

namespace Database\Seeders;

use App\Models\Format;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formats')->delete();

        $formats = [
            'Hardcover',
            'Paperback',
        ];

        // Insert publishers into the database
        foreach ($formats as $format) {
            Format::create([
                'name' => $format,
            ]);
        }

    }
}
