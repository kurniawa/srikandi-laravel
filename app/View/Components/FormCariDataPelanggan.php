<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormCariDataPelanggan extends Component
{
    /**
     * Create a new component instance.
     */
    public $pelangganid;
    public $pelanggannama;
    public $pelangganusername;
    public $pelanggannik;
    public $route;
    public $params;

    public function __construct($pelangganid, $pelanggannama, $pelangganusername, $pelanggannik, $route, $params)
    {
        $this->pelangganid = $pelangganid;
        $this->pelanggannama = $pelanggannama;
        $this->pelangganusername = $pelangganusername;
        $this->pelanggannik = $pelanggannik;
        $this->route = $route;
        $this->params = $params;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-cari-data-pelanggan');
    }
}
