<?php

namespace App\Livewire\Company\CompanyAsset;

use App\Helpers\Alert;
use App\Helpers\PermissionHelper;
use App\Models\Company\CompanyAsset;
use App\Repositories\Account\UserRepository;
use App\Repositories\Company\CompanyAssetRepository;
use App\Traits\Livewire\WithDatatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;


class Datatable extends Component
{
    use WithDatatable;

    public $isCanUpdate;
    public $isCanDelete;

    // Delete Dialog
    public $targetDeleteId;

    public $jenis;

    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_COMPANY_ASSET, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_COMPANY_ASSET, PermissionHelper::TYPE_DELETE));
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        CompanyAssetRepository::delete($this->targetDeleteId);
        Alert::success($this, 'Berhasil', 'Data berhasil dihapus');
    }

    #[On('on-delete-dialog-cancel')]
    public function onDialogDeleteCancel()
    {
        $this->targetDeleteId = null;
    }

    public function showDeleteDialog($id)
    {
        $this->targetDeleteId = $id;

        Alert::confirmation(
            $this,
            Alert::ICON_QUESTION,
            "Hapus Data",
            "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
            "on-delete-dialog-confirm",
            "on-delete-dialog-cancel",
            "Hapus",
            "Batal",
        );
    }

    #[On('refresh-table')]
    public function refreshTable()
    {
        $this->resetPage();
    }


    public function getColumns(): array
    {
        return [
            [
                'name' => 'Action',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $editHtml = "";
                    $id = Crypt::encrypt($item->id);
                    if ($this->isCanUpdate) {
                        $editUrl = route('company_asset.edit', $id);
                        $editHtml = "<div class='col-auto mb-2'>
                            <a class='btn btn-primary btn-sm' href='$editUrl'>
                                <i class='ki-duotone ki-notepad-edit fs-1'>
                                    <span class='path1'></span>
                                    <span class='path2'></span>
                                </i>
                                Ubah
                            </a>
                        </div>";
                    }

                    $destroyHtml = "";
                    if ($this->isCanDelete) {
                        $destroyHtml = "<div class='col-auto mb-2'>
                            <button class='btn btn-danger btn-sm m-0' 
                                wire:click=\"showDeleteDialog($item->id)\">
                                <i class='ki-duotone ki-trash fs-1'>
                                    <span class='path1'></span>
                                    <span class='path2'></span>
                                    <span class='path3'></span>
                                    <span class='path4'></span>
                                    <span class='path5'></span>
                                </i>
                                Hapus
                            </button>
                        </div>";
                    }

                    $qrUrl = route('company_asset_scan_qr.create', $id);
                    $qrHtml = "<div class='col-auto mb-2'>
                            <a class='btn btn-primary btn-sm' href='$qrUrl' target='_BLANK'>
                                <i class='ki-duotone ki-burger-menu-2 fs-1'>
                                    <span class='path1'></span>
                                    <span class='path2'></span>
                                    <span class='path3'></span>
                                    <span class='path4'></span>
                                    <span class='path5'></span>
                                    <span class='path6'></span>
                                    <span class='path7'></span>
                                    <span class='path8'></span>
                                    <span class='path9'></span>
                                    <span class='path10'></span>
                                </i>
                                QR
                            </a>
                        </div>";


                    $html = "<div class='row'>
                        $editHtml 
                        $destroyHtml 
                        $qrHtml
                    </div>";

                    return $html;
                },
            ],
            [
                'key' => 'jenis',
                'name' => 'Jenis',
            ],
            [
                'key' => 'nama_barang',
                'name' => 'Nama Barang',
            ],
            [
                'key' => 'serial_number',
                'name' => 'Nomor Seri',
            ],
            [
                'key' => 'password',
                'name' => 'Password',
            ],
            [
                'key' => 'brand',
                'name' => 'Brand',
            ],
            [
                'key' => 'status_kondisi',
                'name' => 'Status Kondisi',
            ],
            [
                'key' => 'divisi',
                'name' => 'Divisi',
            ],
            [
                'key' => 'assigned_user_name',
                'name' => 'Pengguna saat ini',
                'render' => function ($item) {
                    return $item->assigned_user_name ?? 'Belum ada pengguna';
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return CompanyAssetRepository::datatable($this->jenis);
    }

    public function getView(): string
    {
        return 'livewire.company.company-asset.datatable';
    }
}
