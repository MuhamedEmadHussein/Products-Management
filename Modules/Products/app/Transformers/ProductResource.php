<?php

namespace Modules\Products\App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'name' => $this->name,
            'price' => number_format($this->price, 2),
            'stock' => $this->stock,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'description' => $this->description,
            'notes' => $this->notes,
            'status' => $this->status ? 'Active' : 'Inactive',
            'translations' => $this->getTranslations(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
