<?php

namespace Modules\Products\App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Products\Repositories\ProductRepository;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $showDeleteConfirmation = false;
    public $deleteProductId;

    protected $productRepository;

    public function boot(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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
        return view('products::livewire.products.index',compact('products'));
    }
}
