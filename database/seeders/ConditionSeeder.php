<?php

namespace Database\Seeders;

use App\Models\Condition;
use App\Models\Format;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conditions')->delete();

        $conditions = [
            'New',
            'Excellent',
            'Good',
            'Fair',
            'Poor'
        ];

        // Insert publishers into the database
        foreach ($conditions as $condition) {
            Condition::create([
                'name' => $condition,
            ]);
        }
    }
}
