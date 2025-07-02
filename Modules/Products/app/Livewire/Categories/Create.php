<?php

namespace Modules\Products\App\Livewire\Categories;

use Livewire\Component;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class Create extends Component
{
    public $name, $notes;

    protected $rules = [
        'name' => 'required|string|max:255',
        'notes' => 'nullable|string',
    ];

    protected $categoryRepository;

    public function boot(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function createCategory()
    {
        $this->validate();

        try {
            $this->categoryRepository->create([
                'name' => $this->name,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'Category created successfully');
            $this->resetForm();
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {   
        $this->name = '';
        $this->notes = '';
    }

    public function render()
    {
        return view('products::livewire.categories.create');
    }
}
