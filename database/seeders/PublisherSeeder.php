<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;
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
            'Penguin Random House', 'HarperCollins', 'Simon & Schuster', 'Macmillan',
            'Hachette Book Group', 'Scholastic', 'Bloomsbury', 'Faber & Faber',
            'Vintage Books', 'Knopf Doubleday', 'Crown Publishing', 'Ballantine Books',
            'Bantam Books', 'Del Rey', 'Anchor Books', 'Vintage Classics',
            'Modern Library', 'Everyman\'s Library', 'Oxford University Press', 'Cambridge University Press',
            'MIT Press', 'Harvard University Press', 'Yale University Press', 'Princeton University Press',
            'Stanford University Press', 'University of Chicago Press', 'Columbia University Press',
            'Johns Hopkins University Press', 'Cornell University Press', 'University of California Press'
        ];
        foreach ($publishers as $publisher) {
            Publisher::create([
                'name' => $publisher,
                'archived' => false
            ]);
        }
    }
}
