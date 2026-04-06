<?php

namespace App\Livewire\Company\CompanyAsset;

use App\Helpers\Alert;
use App\Repositories\Account\UserRepository;
use App\Repositories\Company\CompanyAssetRepository;
use App\Repositories\Employee\EmployeeCareerStatusRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Detail extends Component
{

    public $objId;

    public $assigned_user_id;
    public $assigned_at;
    public $nama_barang;
    public $serial_number;
    public $status_barang;
    public $status_kondisi;
    public $status_pembelian;
    public $divisi;
    public $brand;
    public $keterangan;

    public $user_choice = [];

    public function mount()
    {
        if ($this->objId) {
            $company_asset = CompanyAssetRepository::find(Crypt::decrypt($this->objId));

            $this->assigned_user_id = $company_asset->assigned_user_id;
            $this->assigned_at = $company_asset->assigned_at;
            $this->nama_barang = $company_asset->nama_barang;
            $this->serial_number = $company_asset->serial_number;
            $this->status_barang = $company_asset->status_barang;
            $this->status_kondisi = $company_asset->status_kondisi;
            $this->status_pembelian = $company_asset->status_pembelian;
            $this->divisi = $company_asset->divisi;
            $this->brand = $company_asset->brand;
            $this->keterangan = $company_asset->keterangan;
        }
        $this->user_choice = UserRepository::all()->pluck('name', 'id')->toArray();
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('company_asset.edit', $this->objId);
        } else {
            $this->redirectRoute('company_asset.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('company_asset.index');
    }
    public function store()
    {
        try {
            DB::transaction(function () {
                $employee_id = null;
                $validateData = [
                    'assigned_user_id' => $this->assigned_user_id,
                    'assigned_at' => $this->assigned_at,
                    'nama_barang' => $this->nama_barang,
                    'serial_number' => $this->serial_number,
                    'status_barang' => $this->status_barang,
                    'status_kondisi' => $this->status_kondisi,
                    'status_pembelian' => $this->status_pembelian,
                    'divisi' => $this->divisi,
                    'brand' => $this->brand,
                    'keterangan' => $this->keterangan,
                ];
                if ($this->objId) {

                    CompanyAssetRepository::update(Crypt::decrypt($this->objId), $validateData);
                } else {
                    CompanyAssetRepository::create($validateData);
                }
            });


            DB::commit();
            Alert::confirmation(
                $this,
                Alert::ICON_SUCCESS,
                "Berhasil",
                "Data Berhasil Diperbarui",
                "on-dialog-confirm",
                "on-dialog-cancel",
                "Oke",
                "Tutup",
            );
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.company.company-asset.detail');
    }
}
