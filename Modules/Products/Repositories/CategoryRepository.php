<?php

namespace Modules\Products\Repositories;

use Modules\Products\App\Models\Category;
use Illuminate\Support\Facades\Log;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(bool $paginate = true)
    {
        return Category::with('translations')
            ->orderBy('created_at', 'desc')
            ->when($paginate, function ($query) {
                return $query->paginate(10);
            }, function ($query) {
                return $query->get();
            });
    }

    public function find($id)
    {
        return Category::with('translations')->findOrFail($id);
    }

    public function create(array $data)
    {
        
        // Create the category
        $category = new Category();
        $category->save();
        
        // Add translations
        foreach ($data as $locale => $attributes) {
            $category->translateOrNew($locale)->name = $attributes['name'];
            $category->translateOrNew($locale)->notes = $attributes['notes'] ?? null;
        }
        
        $category->save();
        
        Log::info('Category created: ' . json_encode($category->toArray()));
        return $category;
    }

    public function update($id, array $data)
    {
        $category = $this->find($id);
        
        // Update translations
        foreach ($data as $locale => $attributes) {
            $category->translateOrNew($locale)->name = $attributes['name'];
            $category->translateOrNew($locale)->notes = $attributes['notes'] ?? null;
        }
        
        $category->save();
        
        return $category;
    }

    public function delete($id)
    {
        // Log Here
        Log::info('Deleting category ID: ' . $id);
        $category = $this->find($id);
        $category->delete();
        Log::info('Category ID ' . $id . ' deleted');
    }
}