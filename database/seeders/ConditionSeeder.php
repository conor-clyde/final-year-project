<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condition;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conditions')->delete();
        $conditions = ['New', 'Good', 'Fair', 'Poor', 'Damaged'];
        foreach ($conditions as $condition) {
            Condition::create([
                'name' => $condition
            ]);
        }
    }
}
