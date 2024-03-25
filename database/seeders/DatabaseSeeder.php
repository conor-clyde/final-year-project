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
            AuthorSeeder::class,
        ]);

        $this->call([
            GenreSeeder::class,
        ]);

        $this->call([
            PublisherSeeder::class,
        ]);

        $this->call([
           FormatSeeder::class,
        ]);

        $this->call([
            LanguageSeeder::class,
        ]);

        $this->call([
            ConditionSeeder::class,
        ]);

        $this->call([
            BookSeeder::class,
        ]);
        $this->call([
            LoanSeeder::class,
        ]);
    }
}
