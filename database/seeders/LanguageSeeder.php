<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
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
            'English', 'French', 'Spanish', 'German', 'Italian', 'Chinese', 'Japanese', 'Russian', 'Arabic', 'Hindi'
        ];
        foreach ($languages as $language) {
            Language::create([
                'name' => $language
            ]);
        }
    }
}
