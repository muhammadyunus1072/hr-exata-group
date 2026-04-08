<?php

namespace App\Livewire\Company\CompanyAssetScanQr\Scanner;

use App\Helpers\Alert;
use App\Models\Transaction\Transaction;
use App\Repositories\Company\CompanyAssetRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $code = null;

    public function updatedCode($data)
    {
        $this->getData($this->code);
    }
    #[On('on-scanned')]
    public function scanned($data)
    {
        $this->getData($data);
    }

    private function getData($data)
    {
        try {
            $asset = CompanyAssetRepository::find(Crypt::decrypt($data));

            if (!$asset) {
                Alert::fail($this, 'Gagal', 'Data Tidak Ditemukan');
            }

            return redirect()->route('company_asset.edit', ['id' => $data]);
        } catch (DecryptException $e) {
            Alert::fail($this, 'Gagal', 'Data Tidak Ditemukan');
        }
    }

    public function render()
    {
        return view('livewire.company.company-asset-scan-qr.scanner.index');
    }
}
