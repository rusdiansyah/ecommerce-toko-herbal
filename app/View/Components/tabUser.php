<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tabUser extends Component
{
    public $activeTab = 'profile';
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab-user');
    }
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
}
