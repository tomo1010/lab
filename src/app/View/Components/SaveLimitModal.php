<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SaveLimitModal extends Component
{
    public $isOverLimit;

    public function __construct($isOverLimit = false)
    {
        $this->isOverLimit = $isOverLimit;
    }

    public function render()
    {
        return view('components.save-limit-modal');
    }
}
