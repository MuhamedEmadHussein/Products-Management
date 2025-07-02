<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Products\Interfaces\CategoryRepositoryInterface;
use Modules\Products\Interfaces\ProductRepositoryInterface;
use Modules\Products\Repositories\CategoryRepository;
use Modules\Products\Repositories\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind repositories to their interfaces
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
