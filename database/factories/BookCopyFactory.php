<?php

namespace Database\Factories;

use App\Models\CatalogueEntry;
use App\Models\Condition;
use App\Models\Format;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookCopy>
 */
class BookCopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'catalogue_entry_id' => CatalogueEntry::factory(),
            'publisher_id' => Publisher::factory(),
            'condition_id' => Condition::factory(),
            'language_id' => Language::factory(),
            'format_id' => Format::factory(),
            'publish_date' => fake()->date(),
            'pages' => fake()->numberBetween(50, 1000),
            'archived' => false,
        ];
    }
} 