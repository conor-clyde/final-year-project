<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\BookCopy;
use App\Models\CatalogueEntry;
use App\Models\Condition;
use App\Models\Format;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a librarian user
        $this->librarian = User::factory()->create([
            'role' => 2,
            'email' => 'librarian@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_librarian_can_access_book_index()
    {
        $response = $this->actingAs($this->librarian)
            ->get('/book');

        $response->assertStatus(200);
        $response->assertViewIs('book.index');
    }

    public function test_librarian_can_access_book_create_page()
    {
        $response = $this->actingAs($this->librarian)
            ->get('/book/create');

        $response->assertStatus(200);
        $response->assertViewIs('book.create');
    }

    public function test_librarian_can_create_new_book()
    {
        // Create required related data
        $genre = Genre::factory()->create();
        $publisher = Publisher::factory()->create();
        $condition = Condition::factory()->create();
        $language = Language::factory()->create();
        $format = Format::factory()->create();

        $bookData = [
            'new_title' => 'Test Book Title',
            'genre' => $genre->id,
            'new_publisher' => 'Test Publisher',
            'condition' => $condition->id,
            'language' => $language->id,
            'format' => $format->id,
            'publish_day' => 15,
            'publish_month' => 6,
            'publish_year' => 2024,
            'pages' => 300,
            'author_surname' => ['Test'],
            'author_forename' => ['Author'],
        ];

        $response = $this->actingAs($this->librarian)
            ->post('/book/created', $bookData);

        $response->assertRedirect('/book');
        $response->assertSessionHas('flashMessage', 'Book added successfully!');

        // Assert the book was created
        $this->assertDatabaseHas('catalogue_entries', [
            'title' => 'Test Book Title',
        ]);

        $this->assertDatabaseHas('book_copies', [
            'pages' => 300,
        ]);
    }

    public function test_non_librarian_cannot_access_book_management()
    {
        $patron = User::factory()->create(['role' => 1]);

        $response = $this->actingAs($patron)
            ->get('/book');

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_book_management()
    {
        $response = $this->get('/book');

        $response->assertRedirect('/login');
    }
} 