<?php

namespace Modules\Products\App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Modules\Products\Interfaces\ProductRepositoryInterface;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $showDeleteConfirmation = false;
    public $deleteProductId;
    public $locale;
    public $availableLocales = [];
    public $translations = [];

    protected $productRepository;

    protected $listeners = ['localeChanged' => 'updateLocale'];
    
    public function boot(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function mount()
    {
        $this->locale = app()->getLocale();
        $this->availableLocales = config('app.available_locales', ['en']);    
    }

    public function setLocale($locale)
    {
        if (in_array($locale, $this->availableLocales)) {
            $this->locale = $locale;
            app()->setLocale($locale);
            session()->put('locale', $locale);
            $this->resetPage();
        }
    }

    public function updateLocale($event)
    {
        $this->setLocale($event);
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteProductId = $id;
        $this->dispatch('show-delete-confirmation');
    }

    #[On('delete-product')]
    public function deleteProduct()
    {
        try {
            $this->productRepository->delete($this->deleteProductId);
            session()->flash('success', 'Product deleted successfully');
            $this->deleteProductId = null;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $products = $this->productRepository->all();
        return view('products::livewire.products.index', compact('products'));
    }
}
