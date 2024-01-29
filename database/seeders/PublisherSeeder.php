<?php

namespace Database\Seeders;

use App\Models\Genre;
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


        DB::table('publisher')->delete();


        \App\Models\Publisher::create([
            'name' => 'Independently Published',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Atlantic Books',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Penguin',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Wordsworth Editions',
        ]);
        \App\Models\Publisher::create([
            'name' => ' Publisher Hodder Children\'s Books',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Piatkus',
        ]);
        \App\Models\Publisher::create([
            'name' => '1000Vultures',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Penguin Classics',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Head of Zeus',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Bloomsbury Children\'s Books',
        ]);
        \App\Models\Publisher::create([
            'name' => 'New York Review Books',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Knopf',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Thorndike Press Large Print',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Vintage',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Pushkin Press',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Dialogue Books',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Tor',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Hannah Bonam-Young',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Pan',
        ]);
        \App\Models\Publisher::create([
            'name' => 'St. Martin\'s Press',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Berkley Publishing Corporation,U.S.',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Simon & Schuster',
        ]);
        \App\Models\Publisher::create([
            'name' => 'HarperCollins',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Fourth Estate',
        ]);
        \App\Models\Publisher::create([
            'name' => 'Harper Perennial',
        ]);


















}
}
