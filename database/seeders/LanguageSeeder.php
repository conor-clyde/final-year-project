<?php

namespace Database\Seeders;

use App\Models\Format;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->delete();

        $languages = [
            'English'
        ];

        // Insert publishers into the database
        foreach ($languages as $language) {
            Language::create([
                'name' => $language,
            ]);
        }

    }
}
