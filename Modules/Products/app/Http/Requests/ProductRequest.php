<?php

namespace Modules\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'status' => 'required|in:0,1',
        ];
        
        $locales = config('app.available_locales', ['en']);
        
        foreach ($locales as $locale) {
            $rules[$locale.'.name'] = 'required|string|max:255';
            $rules[$locale.'.description'] = 'required|string';
            $rules[$locale.'.notes'] = 'nullable|string';
        }
        
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
