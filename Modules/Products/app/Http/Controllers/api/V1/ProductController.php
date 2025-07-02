<?php

namespace Modules\Products\App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Modules\Products\Interfaces\ProductRepositoryInterface;
use Modules\Products\App\Transformers\ProductResource;
use Modules\Products\App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = $this->productRepository->all();
            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch products'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'products/' . $imageName;
                Storage::disk('public')->putFileAs('products', $image, $imageName);
                $data['image'] = $imagePath;
            }

            $product = $this->productRepository->create($data);
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
        try {
            $product = $this->productRepository->find($id);
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch product'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $product = $this->productRepository->find($id);
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'products/' . $imageName;
                Storage::disk('public')->putFileAs('products', $image, $imageName);
                $data['image'] = $imagePath;
            }

            $product = $this->productRepository->update($id, $data);
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
            return response()->json(['message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product'], 500);
        }
    }
}
