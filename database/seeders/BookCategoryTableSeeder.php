<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryCount = Category::all()->count();

        if (0 === $categoryCount) {
            $this->command->info('No Categories Found. Skipping assigning categories to books!');
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum categories would you like on e books?', 0);
        $howManyMax = min((int)$this->command->ask('categories tags would you like on e books?', $categoryCount), $categoryCount);

        Book::all()->each(function(Book $book) use($howManyMin, $howManyMax) {
            $take = random_int($howManyMin, $howManyMax);
            $categories = Category::inRandomOrder()->take($take)->get()->pluck('id');
            $book->categories()->sync($categories);
        });
    }
}
