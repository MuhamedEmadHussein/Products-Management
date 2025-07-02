<?php
namespace Modules\Products\Repositories;

use Modules\Products\App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    public function all()
    {
        // Log Here
        Log::info('Fetching all products');
        return Product::select('id', 'category_id', 'price', 'stock', 'image', 'description', 'notes', 'status')
            ->with('category')
            ->get();
    }

    public function find($id)
    {
        // Log Here
        Log::info('Finding product ID: ' . $id);
        return Product::with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        // Log Here
        Log::info('Creating product with data: ' . json_encode($data));
        $product = Product::create($data);
        Log::info('Product created: ' . json_encode($product));
        return $product;
    }

    public function update($id, array $data)
    {
        // Log Here
        Log::info('Updating product ID: ' . $id);
        $product = $this->find($id);
        $product->update($data);
        Log::info('Product updated: ' . json_encode($product));
        return $product;
    }

    public function delete($id)
    {
        // Log Here
        Log::info('Deleting product ID: ' . $id);
        $product = $this->find($id);
        $product->delete();
        Log::info('Product ID ' . $id . ' deleted');
    }
}