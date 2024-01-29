<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        $this->call([
            GenreSeeder::class,
        ]);

        $this->call([
            PublisherSeeder::class,
        ]);

        $this->call([
            AuthorSeeder::class,
        ]);

        $this->call([
            BookSeeder::class,
        ]);



    }
}
