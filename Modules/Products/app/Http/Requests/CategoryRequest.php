<?php

namespace Modules\Products\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [];
        $locales = config('app.available_locales', ['en']);
        
        foreach ($locales as $locale) {
            $rules[$locale.'.name'] = 'required|string|max:255';
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
