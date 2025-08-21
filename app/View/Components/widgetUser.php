<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class widgetUser extends Component
{
    public $userId,$name,$role,$photo;
    public $sales,$jmlSales=0;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->userId = Auth::user()->id;
        $this->name = Auth::user()->name;
        $this->role = Auth::user()->role->nama;
        $this->photo = Auth::user()->photo;
        $this->sales = 'Data';
        $this->jmlSales = 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget-user');
    }
}
