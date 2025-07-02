<?php

namespace Modules\Products\App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $productId, $name, $category_id, $price, $stock, $image, $existingImage, $description, $notes, $status;
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

    public function boot(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function mount($id)
    {
        try {
            $product = $this->productRepository->find($id);
            $this->productId = $id;
            $this->name = $product->name;
            $this->category_id = $product->category_id;
            $this->price = $product->price;
            $this->stock = $product->stock;
            $this->existingImage = $product->image;
            $this->description = $product->description;
            $this->notes = $product->notes;
            $this->status = $product->status;
            $this->categories = $this->categoryRepository->all(false);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to load product: ' . $e->getMessage());
            return redirect()->route('products.index');
        }
    }

    public function updateProduct()
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
                if ($this->existingImage) {
                    Storage::disk('public')->delete($this->existingImage);
                }
                $imageName = time() . '.' . $this->image->getClientOriginalExtension();
                $imagePath = 'products/' . $imageName;
                $data['image'] = $imagePath;
                Storage::disk('public')->putFileAs('products', $this->image, $imageName);
            } else {
                $data['image'] = $this->existingImage;
            }

            $this->productRepository->update($this->productId, $data);
            session()->flash('success', 'Product updated successfully');
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update product: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('products::livewire.products.edit');
    }
}
