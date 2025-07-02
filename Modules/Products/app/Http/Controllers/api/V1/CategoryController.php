<?php

namespace Modules\Products\App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Modules\Products\Interfaces\CategoryRepositoryInterface;
use Modules\Products\App\Transformers\CategoryResource;
use Modules\Products\App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $categories = $this->categoryRepository->all();
            return CategoryResource::collection($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch categories'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = $this->categoryRepository->create($data);
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category'], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
        try {
            $category = $this->categoryRepository->find($id);
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch category'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $category = $this->categoryRepository->update($id, $data);
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category'], 500);
        }
    }
}
