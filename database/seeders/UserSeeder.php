<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        \App\Models\user::factory()->create([
            'name' => 'user',
            'email' => 'user@test.com',
            'password' => 'testpassword',
            'role' => '1',
        ]);

        \App\Models\user::factory()->create([
            'name' => 'librarian',
            'email' => 'librarian@test.com',
            'password' => 'testpassword',
            'role' => '2',
        ]);

        \App\Models\user::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => 'testpassword',
            'role' => '3',
        ]);
        
        \App\Models\user::factory(10)->create();
    }
}
