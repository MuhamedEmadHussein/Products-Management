<?php

namespace Modules\Products\App\Livewire;

use Livewire\Component;
use Modules\Products\App\Models\Category;
use Modules\Products\App\Models\Product;

class Home extends Component
{
    public $categoryCount;
    public $productCount;

    public function mount()
    {
        $this->categoryCount = Category::count();
        $this->productCount = Product::count();
    }

    public function render()
    {
        return view('products::livewire.home');
    }
}
