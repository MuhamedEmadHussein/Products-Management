<?php

namespace Modules\Products\App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'notes' => $this->notes,
            'translations' => $this->translations->mapWithKeys(function ($translation) {
                                    return [$translation->locale => [
                                        'name' => $translation->name,
                                        'notes' => $translation->notes,
                                    ]];
                                }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
