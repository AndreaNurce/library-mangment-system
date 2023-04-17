<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $copies = rand(0, 40);
        $title = $this->faker->catchPhrase();
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'description' => $this->faker->paragraphs(5, true), // password
            'publication_year' => $this->faker->dateTimeBetween('-10 years', 'now'), // password
            'pages' => $this->faker->randomDigitNotNull(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'isbn' => $this->faker->isbn13(),
            'copies' => $copies,
            'is_highlighted' => $this->faker->boolean(10),
            'in_stock' => $copies > 0,
        ];
    }
}
