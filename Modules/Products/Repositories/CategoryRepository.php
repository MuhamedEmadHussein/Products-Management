<?php

namespace Modules\Products\Repositories;

use Modules\Products\App\Models\Category;
use Illuminate\Support\Facades\Log;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(bool $paginate = true)
    {
        return Category::select('id', 'name', 'notes', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->when($paginate, function ($query) {
                return $query->paginate(10);
            }, function ($query) {
                return $query->get();
            });
    }

    public function find($id)
    {
        // Log Here
        Log::info('Finding category ID: ' . $id);
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        // Log Here
        Log::info('Creating category with data: ' . json_encode($data));
        $category = Category::create($data);
        Log::info('Category created: ' . json_encode($category));
        return $category;
    }

    public function update($id, array $data)
    {
        // Log Here
        Log::info('Updating category ID: ' . $id);
        $category = $this->find($id);
        $category->update($data);
        Log::info('Category updated: ' . json_encode($category));
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