<?php

namespace Modules\Products\App\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $currentLocale;
    public $availableLocales = ['en' => 'English', 'ar' => 'Arabic'];

    public function mount()
    {
        $this->currentLocale = app()->getLocale();
    }

    public function setLocale($locale)
    {
        if (array_key_exists($locale, $this->availableLocales)) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
            $this->currentLocale = $locale;

            $this->dispatch('localeChanged',$locale);
        }
    }

    public function render()
    {
        return view('products::livewire.language-switcher', [
            'locales' => $this->availableLocales,
        ]);
    }
}
