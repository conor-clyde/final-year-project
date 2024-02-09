<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\CatalogueEntry;
use App\Models\Genre;
use App\Models\Author_CatalogueEntry;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            "The Mindf*ck Series",
            "Call Me By Your Name",
            "Everything I Know About Love : A Memoir",
            "The New Jim Crow",
            "The Divine Comedy",
            "Speak",
            "The Fine Print",
            "Terms and Conditions",
            "Final Offer",
            "Penpal",
            "Persuasion",
            "Pride and Prejudice",
            "Bunny",
            "Tuck Everlasting",
            "Slow Days, Fast Company. The World, the Flesh, and L.A.",
            "Sex and Rage",
            "Where the Truth Lies",
            "The Idiot",
            "Tender Is the Flesh",
            "Nineteen Claws And A Black Bird",
            "The Vanishing Half",
            "Alone With You in the Ether",
            "Out On a Limb",
            "Lovelight Farms",
            "In The Weeds",
            "Mixed Signals",
            "Jane Eyre",
            "Wuthering Heights",
            "Lust & Wonder",
            "Vampires of El Norte",
            "Breakfast at Tiffany's",
            "The Perks of Being a Wallflower",
            "The Alchemist",
            "Blue Nights",
            "Play It as It Lays",
            "The Year of Magical Thinking",
            "The White Album",
            "Slouching Towards Bethlehem",
            "Crime and Punishment"
        ];


        DB::table('author_catalogue_entries')->delete();
        DB::table('catalogue_entries')->delete();
        DB::table('book_copies')->delete();


            for ($i=0; $i<count($books); $i++)
                {
                    $authors = Author::orderByRaw("RAND()")->first();
                    $genres = Genre::orderByRaw("RAND()")->first();
                    $publisher = Publisher::orderByRaw("RAND()")->first();

                    $data = \App\Models\CatalogueEntry::create([
                        'title' => $books[$i],
                        'genre_id' => $genres->id
                    ]);

                    \App\Models\Author_CatalogueEntry::create([
                        'author_id' => $authors->id,
                        'catalogue_entry_id' => $data->id
                    ]);

                    $data = \App\Models\BookCopy::create([
                        'year_published' => 2002,
                        'catalogue_entry_id' => $data->id,
                        'publisher_id' => $publisher->id

                    ]);


                }

    }
}
