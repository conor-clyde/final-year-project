<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loans')->delete();

        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            // Get a random staff_id with role 2 from the staff table
            $staffId = DB::table('staff')->inRandomOrder()->value('id');

            // Get a random book_copy_id from the book_copies table
            $bookCopyId = DB::table('book_copies')->inRandomOrder()->value('id');

            // Get a random user_id with role 1 from the users table
            $patronId = DB::table('patrons')->inRandomOrder()->value('id');

            // Randomly select loan duration (either two weeks or one month)
            $loanDuration = $faker->randomElement(['2 weeks', '1 month']);

            // Set start time randomly
            $start_time = $faker->dateTimeThisYear();
            $start_time = Carbon::instance($start_time);

            // Set end time based on the randomly selected duration
            $end_time = $start_time->copy();
            if ($loanDuration === '2 weeks') {
                $end_time->addWeeks(2);
            } else {
                $end_time->addMonthNoOverflow();
            }

            DB::table('loans')->insert([
                'start_time' => $start_time,
                'end_time' => $end_time,
                'is_returned' => $faker->boolean,
                'book_copy_id' => $bookCopyId,
                'patron_id' => $patronId,
                'staff_id' => $staffId
            ]);
        }
    }
}
