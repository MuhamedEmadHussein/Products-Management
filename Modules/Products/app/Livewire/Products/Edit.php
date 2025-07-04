<?php

namespace Modules\Products\App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Modules\Products\Interfaces\ProductRepositoryInterface;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class Edit extends Component
{
    use WithFileUploads;

    public $productId;
    public $name;
    public $category_id;
    public $price;
    public $stock;
    public $image;
    public $existingImage;
    public $description;
    public $notes;
    public $status;
    public $categories;
    public $locale;
    public $translations = [];
    public $availableLocales = [];

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
    protected $listeners = ['localeChanged' => 'updateLocale'];

    public function boot(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function mount($id)
    {
        try {
            $product = $this->productRepository->find($id);
            $this->productId = $id;
            $this->category_id = $product->category_id;
            $this->price = $product->price;
            $this->stock = $product->stock;
            $this->existingImage = $product->image;
            $this->status = $product->status;
            $this->categories = $this->categoryRepository->all(false);
            $this->locale = app()->getLocale();
            $this->availableLocales = config('app.available_locales', ['en']);
            
            // Initialize translations for all available locales
            foreach ($this->availableLocales as $locale) {
                $translation = $product->translateOrNew($locale);
                $this->translations[$locale] = [
                    'name' => $translation->name ?? '',
                    'description' => $translation->description ?? '',
                    'notes' => $translation->notes ?? '',
                ];
            }
            
            // Set current locale values
            $this->name = $this->translations[$this->locale]['name'];
            $this->description = $this->translations[$this->locale]['description'];
            $this->notes = $this->translations[$this->locale]['notes'];
            
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to load product: ') . $e->getMessage());
            return redirect()->route('products.index');
        }
    }

    public function setLocale($locale)
    {
        if (in_array($locale, $this->availableLocales)) {
            // Save current locale data
            $this->translations[$this->locale]['name'] = $this->name;
            $this->translations[$this->locale]['description'] = $this->description;
            $this->translations[$this->locale]['notes'] = $this->notes;
            
            // Switch locale
            $this->locale = $locale;
            app()->setLocale($locale);
            session()->put('locale', $locale);
            
            // Load data for new locale
            $this->name = $this->translations[$locale]['name'] ?? '';
            $this->description = $this->translations[$locale]['description'] ?? '';
            $this->notes = $this->translations[$locale]['notes'] ?? '';
        }
    }

    public function updateLocale($locale)
    {
        $this->setLocale($locale);
    }

    public function updateProduct()
    {
        $this->validate();
        
        // Save current locale data before submission
        $this->translations[$this->locale]['name'] = $this->name;
        $this->translations[$this->locale]['description'] = $this->description;
        $this->translations[$this->locale]['notes'] = $this->notes;

        try {
            $data = [
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock' => $this->stock,
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
            
            // Only add translation for current locale
            $data[$this->locale] = [
                'name' => $this->name,
                'description' => $this->description ?? '',
                'notes' => $this->notes ?? '',
            ];

            $this->productRepository->update($this->productId, $data);
            session()->flash('success', __('Product updated successfully'));
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to update product: ') . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('products::livewire.products.edit');
    }
}
