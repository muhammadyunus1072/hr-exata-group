<?php

namespace App\Livewire\Company\CompanyAsset;

use Livewire\Component;

class Filter extends Component
{

    public $jenis;

    public function mount() {}

    public function updated()
    {
        $this->dispatch('datatable-add-filter', [
            'jenis' => $this->jenis,
        ]);
    }

    public function render()
    {
        return view('livewire.company.company-asset.filter');
    }
}
