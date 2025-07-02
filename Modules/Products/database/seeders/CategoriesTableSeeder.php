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
        Category::factory()->count(5)->create();
    }
}
