<?php

namespace Modules\Products\App\Livewire\Categories;

use Livewire\Component;
use Modules\Products\Interfaces\CategoryRepositoryInterface;

class Create extends Component
{
    public $name;
    public $notes;
    public $locale;
    public $translations = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'notes' => 'nullable|string',
    ];

    protected $categoryRepository;

    protected $listeners = ['localeChanged' => 'updateLocale'];
    public function boot(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function mount()
    {
        $this->locale = app()->getLocale();
        
        // Initialize translations for all available locales
        foreach (config('app.available_locales', ['en']) as $locale) {
            $this->translations[$locale] = [
                'name' => '',
                'notes' => '',
            ];
        }
        
        // Set current locale values
        $this->translations[$this->locale]['name'] = $this->name ?? '';
        $this->translations[$this->locale]['notes'] = $this->notes ?? '';
    }

    public function updateLocale($event)
    {
        if (in_array($event, config('app.available_locales', ['en']))) {
            // Save current locale data
            $this->translations[$this->locale]['name'] = $this->name;
            $this->translations[$this->locale]['notes'] = $this->notes;
            
            // Switch locale
            $this->locale = $event;
            app()->setLocale($event);
            session()->put('locale', $event);
            
            // Load data for new locale
            $this->name = $this->translations[$event]['name'] ?? '';
            $this->notes = $this->translations[$event]['notes'] ?? '';
        }
    }

    public function createCategory()
    {
        $this->validate();
        
        // Save current locale data before submission
        $this->translations[$this->locale]['name'] = $this->name;
        $this->translations[$this->locale]['notes'] = $this->notes;

        try {
            // Create category with translations
            $categoryData = [];
            foreach ($this->translations as $locale => $translation) {
                if (!empty($translation['name'])) {
                    $categoryData[$locale] = [
                        'name' => $translation['name'],
                        'notes' => $translation['notes'],
                    ];
                }
            }
            
            $this->categoryRepository->create($categoryData);
            session()->flash('success', __('Category created successfully'));
            $this->resetForm();
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to create category: ') . $e->getMessage());
        }
    }

    public function resetForm()
    {   
        $this->name = '';
        $this->notes = '';
        
        foreach (config('translatable.locales', ['en']) as $locale) {
            $this->translations[$locale] = [
                'name' => '',
                'notes' => '',
            ];
        }
    }

    public function render()
    {
        return view('products::livewire.categories.create');
    }
}
