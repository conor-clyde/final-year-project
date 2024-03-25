<?php

namespace Database\Seeders;

use App\Models\Patron;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'surname' => 'user surname',
                'forename' => 'user forename',
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
                'surname' => 'librarian surname',
                'forename' => 'librarian forename',
                'email' => 'librarian@test.com',
            ]);

            // Create an admin with role 3
            User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('testpassword'),
                'role' => 3,
            ]);

            User::factory(10)->create()->each(function ($user) {
                Patron::create([
                    'surname' => 'generated surname',
                    'forename' => 'generated forename',
                    'email' => $user->email,
                ]);
            });
        });
    }
}
