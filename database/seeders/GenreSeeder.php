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

        $genres = [
            'Thriller' => 'A genre characterized by a heightened sense of suspense, mystery, and anticipation.',
            'Literary Fiction' => 'Fictional works that focus more on the quality and depth of the writing than on the plot.',
            'Nonfiction' => 'Books based on real events, facts, and information.',
            'Classic' => 'Timeless literary works that are considered exemplary and have stood the test of time.',
            'Romance' => 'Stories centered around romantic relationships and emotions.',
            'Horror' => 'Designed to create an intense feeling of fear or shock.',
            'Children\'s Literary' => 'Literary works written for and targeted towards children.',
            'Historical Fiction' => 'Fictional stories set against a historical backdrop.',
            'Young Adult' => 'Books aimed at a teenage audience, typically dealing with coming-of-age themes.',
            'Poetry' => 'Expressive and rhythmic literary works often emphasizing the beauty of language.',
            'Fantasy' => 'Imaginative and fantastical stories often set in fictional worlds.',
            'Graphic Novel' => 'Narrative works presented in the form of comic strips or comic book-style storytelling.',
        ];

        foreach ($genres as $genreName => $genreDescription) {
            Genre::create([
                'name' => $genreName,
                'description' => $genreDescription,
            ]);
        }
    }
}
