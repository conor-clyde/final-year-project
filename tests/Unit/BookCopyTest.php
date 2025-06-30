<?php

namespace Tests\Unit;

use App\Models\BookCopy;
use App\Models\CatalogueEntry;
use App\Models\Condition;
use App\Models\Format;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Loan;
use App\Models\Publisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCopyTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_copy_can_be_created()
    {
        $genre = Genre::factory()->create();
        $publisher = Publisher::factory()->create();
        $condition = Condition::factory()->create();
        $language = Language::factory()->create();
        $format = Format::factory()->create();
        
        $catalogueEntry = CatalogueEntry::factory()->create([
            'genre_id' => $genre->id,
        ]);

        $bookCopy = BookCopy::factory()->create([
            'catalogue_entry_id' => $catalogueEntry->id,
            'publisher_id' => $publisher->id,
            'condition_id' => $condition->id,
            'language_id' => $language->id,
            'format_id' => $format->id,
            'publish_date' => '2024-01-15',
            'pages' => 300,
        ]);

        $this->assertDatabaseHas('book_copies', [
            'id' => $bookCopy->id,
            'pages' => 300,
        ]);
    }

    public function test_book_copy_has_catalogue_entry_relationship()
    {
        $catalogueEntry = CatalogueEntry::factory()->create();
        $bookCopy = BookCopy::factory()->create([
            'catalogue_entry_id' => $catalogueEntry->id,
        ]);

        $this->assertInstanceOf(CatalogueEntry::class, $bookCopy->catalogueEntry);
        $this->assertEquals($catalogueEntry->id, $bookCopy->catalogueEntry->id);
    }

    public function test_book_copy_has_publisher_relationship()
    {
        $publisher = Publisher::factory()->create();
        $bookCopy = BookCopy::factory()->create([
            'publisher_id' => $publisher->id,
        ]);

        $this->assertInstanceOf(Publisher::class, $bookCopy->publisher);
        $this->assertEquals($publisher->id, $bookCopy->publisher->id);
    }

    public function test_book_copy_has_condition_relationship()
    {
        $condition = Condition::factory()->create();
        $bookCopy = BookCopy::factory()->create([
            'condition_id' => $condition->id,
        ]);

        $this->assertInstanceOf(Condition::class, $bookCopy->condition);
        $this->assertEquals($condition->id, $bookCopy->condition->id);
    }

    public function test_book_copy_has_language_relationship()
    {
        $language = Language::factory()->create();
        $bookCopy = BookCopy::factory()->create([
            'language_id' => $language->id,
        ]);

        $this->assertInstanceOf(Language::class, $bookCopy->language);
        $this->assertEquals($language->id, $bookCopy->language->id);
    }

    public function test_book_copy_has_format_relationship()
    {
        $format = Format::factory()->create();
        $bookCopy = BookCopy::factory()->create([
            'format_id' => $format->id,
        ]);

        $this->assertInstanceOf(Format::class, $bookCopy->format);
        $this->assertEquals($format->id, $bookCopy->format->id);
    }

    public function test_book_copy_has_loans_relationship()
    {
        $bookCopy = BookCopy::factory()->create();
        $loan = Loan::factory()->create([
            'book_copy_id' => $bookCopy->id,
        ]);

        $this->assertInstanceOf(Loan::class, $bookCopy->loans->first());
        $this->assertEquals($loan->id, $bookCopy->loans->first()->id);
    }

    public function test_book_copy_popularity_returns_loan_count()
    {
        $bookCopy = BookCopy::factory()->create();
        Loan::factory()->count(3)->create([
            'book_copy_id' => $bookCopy->id,
        ]);

        $this->assertEquals(3, $bookCopy->popularity());
    }

    public function test_book_copy_is_on_loan_when_has_active_loan()
    {
        $bookCopy = BookCopy::factory()->create();
        Loan::factory()->create([
            'book_copy_id' => $bookCopy->id,
            'is_returned' => false,
        ]);

        $this->assertTrue($bookCopy->isOnLoan());
    }

    public function test_book_copy_is_not_on_loan_when_all_loans_returned()
    {
        $bookCopy = BookCopy::factory()->create();
        Loan::factory()->create([
            'book_copy_id' => $bookCopy->id,
            'is_returned' => true,
        ]);

        $this->assertFalse($bookCopy->isOnLoan());
    }

    public function test_book_copy_publish_date_is_casted_to_datetime()
    {
        $bookCopy = BookCopy::factory()->create([
            'publish_date' => '2024-01-15',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $bookCopy->publish_date);
    }
} 