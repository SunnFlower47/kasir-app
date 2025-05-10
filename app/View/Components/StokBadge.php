<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
namespace App\View\Components;

use Illuminate\View\Component;

class StokBadge extends Component
{
    public int $stok;

    public function __construct(int $stok)
    {
        $this->stok = $stok;
    }

    public function render()
    {
        return view('components.stok-badge');
    }
}
