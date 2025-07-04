<?php

namespace Modules\Products\Repositories;

use Modules\Products\App\Models\Product;
use Modules\Products\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(bool $paginate = true)
    {
        return Product::with('translations', 'category.translations')
                    ->orderBy('created_at', 'desc')
                    ->when($paginate, function ($query) {
                        return $query->paginate(10);
                    }, function ($query) {
                        return $query->get();
                    });
        
    }

    public function find($id)
    {
        return Product::with('translations', 'category.translations')->findOrFail($id);
    }

    public function create(array $data)
    {
        // Extract non-translatable attributes
        $translationLocales = config('app.available_locales', ['en']);

        // Split base data and translation data
        $baseData = array_filter($data, function ($key) use ($translationLocales) {
            return !in_array($key, $translationLocales);
        }, ARRAY_FILTER_USE_KEY);

        $translations = array_filter($data, function ($key) use ($translationLocales) {
            return in_array($key, $translationLocales);
        }, ARRAY_FILTER_USE_KEY);

        // Create base product
        $product = Product::create($baseData);

        // Attach translations
        foreach ($translations as $locale => $fields) {
            if (is_array($fields)) {
                $product->translateOrNew($locale)->name = $fields['name'] ?? '';
                $product->translateOrNew($locale)->description = $fields['description'] ?? '';
                $product->translateOrNew($locale)->notes = $fields['notes'] ?? '';
            }
        }

        $product->save();
        return $product;
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        
        // Update non-translatable attributes
        if (isset($data['category_id'])) $product->category_id = $data['category_id'];
        if (isset($data['price'])) $product->price = $data['price'];
        if (isset($data['stock'])) $product->stock = $data['stock'];
        if (isset($data['image'])) $product->image = $data['image'];
        if (isset($data['status'])) $product->status = $data['status'];
        
        // Save non-translatable attributes
        $product->save();
     
        
        // Add translation for specific locale if provided
        foreach ($data as $locale => $translation) {
            if (in_array($locale, config('app.available_locales', ['en'])) && is_array($translation)) {
                $trans = $product->translateOrNew($locale);
                $trans->name = $translation['name'] ?? '';
                $trans->description = $translation['description'] ?? '';
                $trans->notes = $translation['notes'] ?? '';
                $trans->save();
            }
        }
        
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        $product->delete();
    }
}