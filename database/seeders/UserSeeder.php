<?php

namespace Database\Seeders;

use App\Models\Patron;
use App\Models\Staff;
use App\Models\User;
use App\Helpers\DataGenerator;
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

        // Create a user with role 1
        $user = User::create([
            'name' => 'user',
            'email' => 'user@test.com',
            'password' => bcrypt('testpassword'),
            'role' => 1,
        ]);
        Patron::create([
            'surname' => 'testSurname',
            'forename' => 'testForename',
            'email' => 'user@test.com',
        ]);

        // Create a librarian with role 2
        $librarian = User::create([
            'name' => 'librarian',
            'email' => 'librarian@test.com',
            'password' => bcrypt('testpassword'),
            'role' => 2,
        ]);
        Staff::create([
            'surname' => 'Smith',
            'forename' => 'Librarian',
            'email' => 'librarian@test.com',
        ]);

        // Create an admin with role 3
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('testpassword'),
            'role' => 3,
        ]);

        // Create 10 random users and patrons
        for ($i = 0; $i < 10; $i++) {
            $name = DataGenerator::fullName();
            $email = DataGenerator::email(strtolower(str_replace(' ', '.', $name)));
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('testpassword'),
                'role' => 1,
            ]);
            Patron::create([
                'surname' => DataGenerator::lastName(),
                'forename' => DataGenerator::firstName(),
                'email' => $email,
            ]);
        }
    }
}
