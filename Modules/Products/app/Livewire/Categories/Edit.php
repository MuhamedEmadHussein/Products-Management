<?php

namespace Modules\Products\App\Livewire\Categories;

use Livewire\Component;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class Edit extends Component
{
    
    public $categoryId, $name, $notes;

    protected $rules = [
        'name' => 'required|string|max:255',
        'notes' => 'nullable|string',
    ];

    protected $categoryRepository;

    public function boot(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function mount($categoryId)
    {
        try {
            $category = $this->categoryRepository->find($categoryId);
            $this->categoryId = $categoryId;
            $this->name = $category->name;
            $this->notes = $category->notes;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to load category: ' . $e->getMessage());
            return redirect()->route('categories.index');
        }
    }

    public function updateCategory()
    {
        $this->validate();

        try {
            $this->categoryRepository->update($this->categoryId, [
                'name' => $this->name,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'Category updated successfully');
            $this->resetForm();
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->notes = '';
    }
    public function render()
    {
        return view('products::livewire.categories.edit');
    }
}
