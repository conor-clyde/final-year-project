<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\BookCopy;
use App\Models\Patron;
use App\Models\Staff;
use App\Helpers\DataGenerator;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some book copies, patrons, and staff for creating loans
        $bookCopies = BookCopy::all();
        $patrons = Patron::all();
        $staff = Staff::all();

        if ($bookCopies->isEmpty() || $patrons->isEmpty() || $staff->isEmpty()) {
            return; // Don't create loans if we don't have the required data
        }

        // Create some sample loans
        for ($i = 0; $i < 20; $i++) {
            $bookCopy = $bookCopies->random();
            $patron = $patrons->random();
            $staffMember = $staff->random();

            // Random loan date (within last 2 years)
            $loanDate = DataGenerator::randomDate(2022, 2024);
            
            // Random return date (some loans returned, some not)
            $returnDate = null;
            if (rand(1, 3) > 1) { // 2/3 chance of being returned
                $returnDate = date('Y-m-d', strtotime($loanDate . ' + ' . rand(1, 30) . ' days'));
            }

            Loan::create([
                'book_copy_id' => $bookCopy->id,
                'patron_id' => $patron->id,
                'staff_id' => $staffMember->id,
                'loan_date' => $loanDate,
                'due_date' => date('Y-m-d', strtotime($loanDate . ' + 14 days')),
                'return_date' => $returnDate,
                'created_at' => $loanDate,
                'updated_at' => $returnDate ?? now(),
            ]);
        }
    }
}
