<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->delete();
        $genres = [
            'Fiction', 'Non-Fiction', 'Mystery', 'Thriller', 'Romance', 'Science Fiction',
            'Fantasy', 'Horror', 'Biography', 'Autobiography', 'History', 'Philosophy',
            'Psychology', 'Self-Help', 'Business', 'Economics', 'Politics', 'Religion',
            'Science', 'Technology', 'Art', 'Music', 'Travel', 'Cooking', 'Health',
            'Fitness', 'Education', 'Reference', 'Poetry', 'Drama', 'Comedy'
        ];
        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre,
                'description' => \App\Helpers\DataGenerator::randomText(10)
            ]);
        }
    }
}
