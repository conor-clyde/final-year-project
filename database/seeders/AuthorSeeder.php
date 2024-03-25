<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->delete();

        $authorsData = [
            ['forename' => 'Abby', 'surname' => 'Abby'],
            ['forename' => 'André', 'surname' => 'Aciman'],
            ['forename' => 'Dolly', 'surname' => 'Alderton'],
            ['forename' => 'Michelle', 'surname' => 'Alexander'],
            ['forename' => 'Dante', 'surname' => 'Alighieri'],
            ['forename' => 'Laurie Halse', 'surname' => 'Anderson'],
            ['forename' => 'Lauren', 'surname' => 'Asher'],
            ['forename' => 'Dathan', 'surname' => 'Auerbach'],
            ['forename' => 'Jane', 'surname' => 'Austen'],
            ['forename' => 'Mona', 'surname' => 'Awad'],
            ['forename' => 'Natalie', 'surname' => 'Babbitt'],
            ['forename' => 'Eve', 'surname' => 'Babitz'],
            ['forename' => 'Anna', 'surname' => 'Bailey'],
            ['forename' => 'Elif', 'surname' => 'Batuman'],
            ['forename' => 'Agustina', 'surname' => 'Bazterrica'],
            ['forename' => 'Brit', 'surname' => 'Bennett'],
            ['forename' => 'Olivia', 'surname' => 'Blake'],
            ['forename' => 'Hannah', 'surname' => 'Bonam-Young'],
            ['forename' => 'B.K.', 'surname' => 'Borison'],
            ['forename' => 'Charlotte', 'surname' => 'Brontë'],
            ['forename' => 'Emily', 'surname' => 'Brontë'],
            ['forename' => 'Augesten', 'surname' => 'Burroughs'],
            ['forename' => 'Isabel', 'surname' => 'Cañas'],
            ['forename' => 'Truman', 'surname' => 'Capote'],
            ['forename' => 'Stephen', 'surname' => 'Chbosky'],
            ['forename' => 'Paulo', 'surname' => 'Coelho'],
            ['forename' => 'Joan', 'surname' => 'Didion'],
            ['forename' => 'Fyodor', 'surname' => 'Dostoecsky'],
            ['forename' => 'J. ', 'surname' => 'Elle'],
            ['forename' => 'Bret Easton', 'surname' => 'Ellis'],
            ['forename' => 'Jeffrey', 'surname' => 'Eugenides'],
            ['forename' => 'F.Scott', 'surname' => 'Fitzgerald'],
            ['forename' => 'Gillian', 'surname' => 'Flynn'],
            ['forename' => 'Connor', 'surname' => 'Franta'],
            ['forename' => 'Roxane', 'surname' => 'Gay'],
            ['forename' => 'Bob', 'surname' => 'Goff'],
            ['forename' => 'Willian', 'surname' => 'Golding'],
            ['forename' => 'Hannah', 'surname' => 'Grace'],
            ['forename' => 'Marlowe', 'surname' => 'Granados'],
            ['forename' => 'John', 'surname' => 'Green'],
            ['forename' => 'Andrew Sean', 'surname' => 'Greer'],
            ['forename' => 'Stephen', 'surname' => 'Hawking'],
            ['forename' => 'Ali', 'surname' => 'Hazelwood'],
            ['forename' => 'Talia', 'surname' => 'Hibbert'],
            ['forename' => 'Helen', 'surname' => 'Hoang'],
            ['forename' => 'Chelsea', 'surname' => 'Hodson'],
            ['forename' => 'Sarah', 'surname' => 'Hogle'],
            ['forename' => 'Ana', 'surname' => 'Huang'],
            ['forename' => 'Shirley', 'surname' => 'Jackson'],
            ['forename' => 'Henry', 'surname' => 'James'],
            ['forename' => 'Abby', 'surname' => 'Jimenez'],
            ['forename' => 'Han', 'surname' => 'Kang'],
            ['forename' => 'Susanna', 'surname' => 'Kaysen'],
            ['forename' => 'Deborah Elaine', 'surname' => 'Kennedy'],
            ['forename' => 'Josh', 'surname' => 'Kilmer-Purcell'],
            ['forename' => 'Lily', 'surname' => 'King'],
            ['forename' => 'Stephan', 'surname' => 'King'],
            ['forename' => 'E.L.', 'surname' => 'Konigsburg'],
            ['forename' => 'Harper', 'surname' => 'Lee'],
            ['forename' => 'Raven', 'surname' => 'Leilani'],
            ['forename' => 'Chloe', 'surname' => 'Liese'],
            ['forename' => 'Rachael', 'surname' => 'Lippincot'],
            ['forename' => 'Ling', 'surname' => 'Ma'],
            ['forename' => 'Sarah J.', 'surname' => 'Maas'],
        ];

        foreach ($authorsData as $authorData) {
            Author::create($authorData);
        }
    }
}
