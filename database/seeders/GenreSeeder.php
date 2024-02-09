<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->delete();

        \App\Models\Genre::create([
            'name' => 'Thriller',
            ]);

        \App\Models\Genre::create([
            'name' => 'Literary Fiction',
        ]);

        \App\Models\Genre::create([
            'name' => 'Nonfiction',
        ]);

        \App\Models\Genre::create([
            'name' => 'Classic',
        ]);

        \App\Models\Genre::create([
            'name' => 'Romance',
        ]);

        \App\Models\Genre::create([
            'name' => 'Horror',
        ]);

        \App\Models\Genre::create([
            'name' => 'Children\'s Literary',
        ]);

        \App\Models\Genre::create([
            'name' => 'Historical Fiction',
        ]);

        \App\Models\Genre::create([
            'name' => 'Young Adult',
        ]);

        \App\Models\Genre::create([
            'name' => 'Poetry',
        ]);

        \App\Models\Genre::create([
            'name' => 'Fantasy',
        ]);

        \App\Models\Genre::create([
            'name' => 'Graphic Novel',
        ]);
    }
}
