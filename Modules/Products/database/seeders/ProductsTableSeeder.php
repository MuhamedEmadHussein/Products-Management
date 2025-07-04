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
        // Create 20 products with English translations
        Product::factory()->count(20)->create();
        
        // Add Arabic translations to existing products
        Product::all()->each(function ($product) {
            $product->translateOrNew('ar')->name = 'منتج ' . $product->id;
            $product->translateOrNew('ar')->description = 'وصف المنتج ' . $product->id;
            $product->translateOrNew('ar')->notes = 'ملاحظات للمنتج ' . $product->id;
            $product->save();
        });
    }
}
