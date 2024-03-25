<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('publishers')->delete();

        $publishers = [
            'Independently Published',
            'Atlantic Books',
            'Penguin',
            'Wordsworth Editions',
            'Hodder Children\'s Books',
            'Piatkus',
            '1000Vultures',
            'Penguin Classics',
            'Head of Zeus',
            'Bloomsbury Children\'s Books',
            'New York Review Books',
            'Knopf',
            'Thorndike Press Large Print',
            'Vintage',
            'Pushkin Press',
            'Dialogue Books',
            'Tor',
            'Hannah Bonam-Young',
            'Pan',
            'St. Martin\'s Press',
            'Berkley Publishing Corporation,U.S.',
            'Simon & Schuster',
            'HarperCollins',
            'Fourth Estate',
            'Harper Perennial',
        ];



        // Insert publishers into the database
        foreach ($publishers as $publisher) {
            Publisher::create([
                'name' => $publisher,
            ]);
        }

    }
}
