<?php

namespace Modules\Products\Repositories;

use Modules\Products\App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    public function all(bool $paginate = true)
    {
        return Product::select('id','name', 'category_id', 'price', 'stock', 'image', 'description', 'notes', 'status','created_at')
                    ->with('category')
                    ->orderBy('created_at', 'desc')
                    ->when($paginate, function ($query) {
                        return $query->paginate(10);
                    }, function ($query) {
                        return $query->get();
                    });
        
    }

    public function find($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        $product = Product::create($data);
        return $product;
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        $product->delete();
    }
}