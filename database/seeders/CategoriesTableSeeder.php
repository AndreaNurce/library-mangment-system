<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()->create([
            'title'      => 'Romance',
        ]);

        Category::query()->create([
            'title'      => 'Aksion',
        ]);

        Category::query()->create([
            'title'      => 'Aventure',
        ]);

        Category::query()->create([
            'title'      => 'Poema',
        ]);

        Category::query()->create([
            'title'      => 'Tregime',
        ]);

        Category::query()->create([
            'title'      => 'Biografi',
        ]);

        Category::query()->create([
            'title'      => 'Udhetime',
        ]);

        Category::query()->create([
            'title'      => 'Shkrime Letrare',
        ]);

        Category::query()->create([
            'title'      => 'Motivues',
        ]);

        Category::query()->create([
            'title'      => 'Shkollor',
        ]);

    }
}
