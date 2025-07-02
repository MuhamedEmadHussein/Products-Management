<?php

namespace Modules\Products\App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Modules\Products\Interfaces\ProductRepositoryInterface;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class Create extends Component
{
    use WithFileUploads;

    public $name, $category_id, $price, $stock, $image, $description, $notes, $status;
    public $categories;

    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'description' => 'required|string',
        'notes' => 'nullable|string',
        'status' => 'required|in:0,1',
    ];

    protected $productRepository;
    protected $categoryRepository;

    public function boot(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function mount()
    {
        $this->categories = $this->categoryRepository->all(false);
        $this->status = 1;
    }

    public function createProduct()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock' => $this->stock,
                'description' => $this->description,
                'notes' => $this->notes,
                'status' => $this->status,
            ];

            if ($this->image) {
                $imageName = time() . '.' . $this->image->getClientOriginalExtension();
                $imagePath = 'products/' . $imageName;
                Storage::disk('public')->putFileAs('products', $this->image, $imageName);
                $data['image'] = $imagePath;
            }

            $this->productRepository->create($data);

            session()->flash('success', 'Product created successfully');
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create product: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('products::livewire.products.create');
    }
}
