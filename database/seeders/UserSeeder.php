<?php

namespace Database\Seeders;

use App\Models\Patron;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patrons')->delete();
        DB::table('staff')->delete();
        DB::table('users')->delete();

        // Disable model events during seeding
        User::withoutEvents(function () {

            // Create a user with role 1
            User::factory()->create([
                'name' => 'user',
                'email' => 'user@test.com',
                'password' => bcrypt('testpassword'), // Ensure to hash passwords
                'role' => 1,
            ]);

            Patron::create([
                'surname' => 'testSurname',
                'forename' => 'testForename',
                'email' => 'user@test.com',
            ]);

            // Create a librarian with role 2
            User::factory()->create([
                'name' => 'librarian',
                'email' => 'librarian@test.com',
                'password' => bcrypt('testpassword'),
                'role' => 2,
            ]);

            Staff::create([
                'surname' => 'Librarian',
                'forename' => 'Smith',
                'email' => 'librarian@test.com',
            ]);

            // Create an admin with role 3
            User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('testpassword'),
                'role' => 3,
            ]);

            $faker = FakerFactory::create();

            User::factory(10)->create()->each(function ($user) use ($faker) {
                Patron::create([
                    'surname' => $faker->lastName,
                    'forename' => $faker->firstName,
                    'email' => $user->email,
                ]);
            });
        });
    }
}
