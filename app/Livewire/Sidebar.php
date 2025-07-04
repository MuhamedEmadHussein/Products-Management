<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public $locale;

    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    protected $listeners = ['localeChanged' => 'updateLocale'];
    public function updateLocale($event)
    {
        $this->locale = $event;
        app()->setLocale($this->locale);
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
