<?php

namespace Modules\Products\App\Livewire\Categories;

use Livewire\Component;
use Modules\Products\Repositories\CategoryRepository;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $deleteCategoryId;

    protected $paginationTheme = 'bootstrap';

    protected CategoryRepository $categoryRepository;

    public function boot(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function confirmDelete($categoryId)
    {
        $this->deleteCategoryId = $categoryId;
        $this->dispatch('show-delete-confirmation', categoryId: $categoryId);
    }

    #[On('delete-category')]
    public function deleteCategory()
    {
        try {
            if ($this->deleteCategoryId) {
                $this->categoryRepository->delete($this->deleteCategoryId);
                session()->flash('success', 'Category deleted successfully');
                $this->deleteCategoryId = null;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $categories = $this->categoryRepository->all();
        return view('products::livewire.categories.index', compact('categories'));
    }

}
