<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Products\App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 categories with English translations
        Category::factory()->count(5)->create();
        
        // Add Arabic translations to existing categories
        Category::all()->each(function ($category) {
            $category->translateOrNew('ar')->name = 'فئة ' . $category->id;
            $category->translateOrNew('ar')->notes = 'ملاحظات للفئة ' . $category->id;
            $category->save();
        });
    }
}
