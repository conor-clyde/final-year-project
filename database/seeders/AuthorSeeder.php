<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->delete();

        \App\Models\Author::create([
            'forename' => 'S.T.',
            'surname' => 'Abby'
        ]);      \App\Models\Author::create([
        'forename' => '

André',
        'surname' => 'Aciman'
    ]);      \App\Models\Author::create([
        'forename' => '

Dolly',
        'surname' => 'Alderton'
    ]);      \App\Models\Author::create([
        'forename' => '

Michelle',
        'surname' => 'Alexander'
    ]);      \App\Models\Author::create([
        'forename' => '

Dante',
        'surname' => 'Alighieri'
    ]);      \App\Models\Author::create([
        'forename' => '

Laurie Halse',
        'surname' => 'Anderson'
    ]);      \App\Models\Author::create([
        'forename' => '

Lauren',
        'surname' => 'Asher'
    ]);      \App\Models\Author::create([
        'forename' => '

Lauren',
        'surname' => 'Asher'
    ]);      \App\Models\Author::create([
        'forename' => '

Lauren',
        'surname' => 'Asher'
    ]);      \App\Models\Author::create([
        'forename' => '

Dathan',
        'surname' => 'Auerbach'
    ]);      \App\Models\Author::create([
        'forename' => '

Jane',
        'surname' => 'Austen'
    ]);      \App\Models\Author::create([
        'forename' => '

Jane',
        'surname' => 'Austen'
    ]);      \App\Models\Author::create([
        'forename' => '

Mona',
        'surname' => 'Awad'
    ]);      \App\Models\Author::create([
        'forename' => '

Natalie',
        'surname' => 'Babbitt'
    ]);      \App\Models\Author::create([
        'forename' => '

Eve',
        'surname' => 'Babitz'
    ]);      \App\Models\Author::create([
        'forename' => '

Eve',
        'surname' => 'Babitz'
    ]);      \App\Models\Author::create([
        'forename' => '

Anna',
        'surname' => 'Bailey'
    ]);      \App\Models\Author::create([
        'forename' => '

Elif',
        'surname' => 'Batuman'
    ]);      \App\Models\Author::create([
        'forename' => '

Agustina',
        'surname' => 'Bazterrica'
    ]);      \App\Models\Author::create([
        'forename' => '

Agustina',
        'surname' => 'Bazterrica'
    ]);      \App\Models\Author::create([
        'forename' => '

Brit',
        'surname' => 'Bennett'
    ]);      \App\Models\Author::create([
        'forename' => '

Olivia',
        'surname' => 'Blake'
    ]);      \App\Models\Author::create([
        'forename' => '

Hannah',
        'surname' => 'Bonam-Young'
    ]);      \App\Models\Author::create([
        'forename' => '

B.K.',
        'surname' => 'Borison'
    ]);      \App\Models\Author::create([
        'forename' => '

B.K.',
        'surname' => 'Borison'
    ]);      \App\Models\Author::create([
        'forename' => '

B.K.',
        'surname' => 'Borison'
    ]);      \App\Models\Author::create([
        'forename' => '

Charlotte',
        'surname' => 'Brontë'
    ]);      \App\Models\Author::create([
        'forename' => '

Emily',
        'surname' => 'Brontë',
    ]);      \App\Models\Author::create([
        'forename' => '

Augesten',
        'surname' => 'Burroughs'
    ]);      \App\Models\Author::create([
        'forename' => '

Isabel',
        'surname' => 'Cañas'
    ]);      \App\Models\Author::create([
        'forename' => '

Truman',
        'surname' => 'Capote'
    ]);      \App\Models\Author::create([
        'forename' => '

Stephen',
        'surname' => 'Chbosky'
    ]);      \App\Models\Author::create([
        'forename' => '

Paulo',
        'surname' => 'Coelho'
    ]);      \App\Models\Author::create([
        'forename' => '

Joan',
        'surname' => 'Didion'
    ]);      \App\Models\Author::create([
        'forename' => '

Joan',
        'surname' => 'Didion'
    ]);      \App\Models\Author::create([
        'forename' => '

Joan',
        'surname' => 'Didion'
    ]);      \App\Models\Author::create([
        'forename' => '

Joan',
        'surname' => 'Didion'
    ]);      \App\Models\Author::create([
        'forename' => '

Joan',
        'surname' => 'Didion'
    ]);      \App\Models\Author::create([
        'forename' => '

Fyodor',
        'surname' => 'Dostoecsky'
    ]);


    }
}
