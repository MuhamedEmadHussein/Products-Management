<?php

namespace Modules\Products\App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class Index extends Component
{
    use WithPagination;

    public $deleteCategoryId;
    public $locale;

    protected $paginationTheme = 'bootstrap';
    protected $categoryRepository;
    
    protected $listeners = ['delete-category' => 'deleteCategory', 'localeChanged' => 'updateLocale'];

    public function boot(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    public function updateLocale($event)
    {
        if (in_array($event, config('app.available_locales', ['en']))) {
            app()->setLocale($event);
            session()->put('locale', $event);
            $this->locale = $event;
            $this->resetPage();
        }
    }

    public function confirmDelete($categoryId)
    {
        $this->deleteCategoryId = $categoryId;
        $this->dispatch('show-delete-confirmation', categoryId: $categoryId);
    }

    public function deleteCategory()
    {
        try {
            if ($this->deleteCategoryId) {
                $this->categoryRepository->delete($this->deleteCategoryId);
                $this->deleteCategoryId = null;
                session()->flash('success', __('Category deleted successfully'));
            }
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to delete category: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $categories = $this->categoryRepository->all();
        return view('products::livewire.categories.index', compact('categories'));
    }
}