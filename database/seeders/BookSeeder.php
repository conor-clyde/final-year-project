<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\BookCopy;
use App\Models\CatalogueEntry;
use App\Models\Condition;
use App\Models\Format;
use App\Models\Genre;
use App\Models\Author_CatalogueEntry;
use App\Models\Language;
use App\Models\Publisher;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('author_catalogue_entries')->delete();
        DB::table('catalogue_entries')->delete();
        DB::table('book_copies')->delete();

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
            "Crime and Punishment",
            "House of Marionne",
            "American Psycho",
            "The Virgin Suicides",
            "The Great Gatsby",
            "Gone Girl",
            "Note To Self",
            "A Work In Progress: A Memoir",
            "Bad Feminist",
            "Hunger: A Memoir of (My) Body",
            "Everybody, Always",
            "Love Does",
            "Lord of the Flies",
            "Icebreaker",
            "Wildfire",
            "Special Edition: Icebreaker",
            "Special Edition: Wildfire",
            "Happy Hour",
            "Looking For Alaska",
            "Turtles All the Way Down",
            "Less",
            "Less Is Lost",
            "A Brief History of Time",
            "Love on the Brain",
            "Love, Theoretically",
            "Check & Mate",
            "Get a Life, Chloe Brown",
            "Take a Hint, Dani Brown",
            "Act Your Age, Eve Brown",
            "The Kiss Quotient",
            "The Bride Test",
            "The Heart Principle",
            "Tonight I'm Someone Else",
            "You Deserve Each Other",
            "Twisted Love",
            "The Haunting of Hill House",
            "We Have Always Lived in the Castle",
            "The Turn of The Screw",
            "Part of Your World",
            "Yours Truly",
            "The Vegetarian",
            "Girl, Interrupted",
            "Tornado Weather",
            "I am Not Myself These Days",
            "Writers & Lovers",
            "Misery",
            "From the Mixed-Up Files of Mrs. Basil E. Frankweiler",
            "To Kill a Mockingbird",
            "Go Set a Watchman",
            "Luster",
            "Only When It's Us",
            "Always Only You",
            "Ever After Always",
            "With You Forever",
            "Everything for You",
            "If Only You",
            "Two Wrongs Make a Right",
            "The Mistletoe Motive",
            "Better Hate Than Never",
            "Five Feet Apart",
            "Severance",
            "The Assassins Blade",
        ];

        // Keep track of existing CatalogueEntry instances
        $existingCatalogueEntries = [];

        foreach ($books as $bookTitle) {
            // Determine if this BookCopy should be created for an existing CatalogueEntry or a new one
            $createForExistingCatalogueEntry = rand(0, 9) == 0 && count($existingCatalogueEntries) > 0;

            if ($createForExistingCatalogueEntry) {
                // Randomly choose an existing CatalogueEntry
                $catalogueEntry = $existingCatalogueEntries[array_rand($existingCatalogueEntries)];
            } else {
                // Create a new CatalogueEntry
                $genre = Genre::inRandomOrder()->first();
                $catalogueEntry = CatalogueEntry::create([
                    'title' => $bookTitle,
                    'genre_id' => $genre->id,
                    'description' => \App\Helpers\DataGenerator::randomText(30)
                ]);

                // Store the new CatalogueEntry
                $existingCatalogueEntries[] = $catalogueEntry;

                $authors = Author::inRandomOrder()->limit(rand(1, min(3, Author::count())))->get();

                foreach ($authors as $author) {
                    // Use firstOrCreate to ensure uniqueness of the combination of author_id and catalogue_entry_id
                    Author_CatalogueEntry::firstOrCreate([
                        'author_id' => $author->id,
                        'catalogue_entry_id' => $catalogueEntry->id,
                    ]);
                }
            }

            // Create a new BookCopy for the chosen CatalogueEntry
            $publisher = Publisher::inRandomOrder()->first();
            $language = Language::inRandomOrder()->first();
            $format = Format::inRandomOrder()->first();
            $condition = Condition::inRandomOrder()->first();

            $publishDate = \App\Helpers\DataGenerator::randomDate(1920, 2024);

            BookCopy::create([
                'catalogue_entry_id' => $catalogueEntry->id,
                'condition_id' => $condition->id,
                'publisher_id' => $publisher->id,
                'publish_date' => $publishDate,
                'language_id' => $language->id,
                'format_id' => $format->id,
                'pages' => rand(50, 1000)
            ]);
        }
    }
    private function generateRandomDescription(): string
    {
        $length = rand(1, 1500);
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ';
        $description = '';

        for ($i = 0; $i < $length; $i++) {
            $description .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $description;
    }


}
