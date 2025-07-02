<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Products\App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->count(20)->create();
    }
}
