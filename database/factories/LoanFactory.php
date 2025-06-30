<?php

namespace Database\Factories;

use App\Models\BookCopy;
use App\Models\Patron;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create a user first
        $user = User::factory()->create();
        
        // Create patron with the same email
        $patron = Patron::factory()->create([
            'email' => $user->email,
        ]);
        
        // Create another user for staff
        $staffUser = User::factory()->create();
        
        // Create staff with the same email
        $staff = Staff::factory()->create([
            'email' => $staffUser->email,
        ]);

        return [
            'book_copy_id' => BookCopy::factory(),
            'patron_id' => $patron->id,
            'staff_id' => $staff->id,
            'start_time' => fake()->dateTimeBetween('-1 year', 'now'),
            'end_time' => fake()->dateTimeBetween('now', '+1 month'),
            'is_returned' => fake()->boolean(20), // 20% chance of being returned
        ];
    }
} 