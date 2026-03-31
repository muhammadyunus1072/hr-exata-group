<?php

namespace App\Livewire\Employee\Employee;

use App\Helpers\Alert;
use App\Helpers\PermissionHelper;
use App\Repositories\Account\UserRepository;
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

    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_EMPLOYEE, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_EMPLOYEE, PermissionHelper::TYPE_DELETE));
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        UserRepository::delete($this->targetDeleteId);
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
                        $editUrl = route('employee.edit', $id);
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
                    // if ($this->isCanDelete) {
                    //     $destroyHtml = "<div class='col-auto mb-2'>
                    //         <button class='btn btn-danger btn-sm m-0' 
                    //             wire:click=\"showDeleteDialog($item->id)\">
                    //             <i class='ki-duotone ki-trash fs-1'>
                    //                 <span class='path1'></span>
                    //                 <span class='path2'></span>
                    //                 <span class='path3'></span>
                    //                 <span class='path4'></span>
                    //                 <span class='path5'></span>
                    //             </i>
                    //             Hapus
                    //         </button>
                    //     </div>";
                    // }

                    $html = "<div class='row'>
                        $editHtml 
                        $destroyHtml 
                    </div>";

                    return $html;
                },
            ],
            [
                'key' => 'nomor_karyawan',
                'name' => 'Nomor Karyawan',
            ],
            [
                'key' => 'name',
                'name' => 'Nama Karyawan',
            ],
            [
                'key' => 'nomor_identitas',
                'name' => 'Nomor Identitas',
            ],
            [
                'key' => 'tempat_lahir',
                'name' => 'Tempat Lahir',
            ],
            [
                'key' => 'tanggal_lahir',
                'name' => 'Tanggal Lahir',
            ],
            [
                'key' => 'jenis_kelamin',
                'name' => 'Jenis Kelamin',
            ],
            [
                'key' => 'agama',
                'name' => 'Agama',
            ],
            [
                'key' => 'status_perkawinan',
                'name' => 'Status Perkawianan',
            ],
            [
                'key' => 'pendidikan_terakhir',
                'name' => 'Pendidikan Terakhir',
            ],
            [
                'key' => 'no_telp_pribadi',
                'name' => 'No. Telp Pribadi',
            ],
            [
                'key' => 'no_telp_kantor',
                'name' => 'No. Telp Kantor',
            ],
            [
                'key' => 'email_pribadi',
                'name' => 'Email Pribadi',
            ],
            [
                'key' => 'alamat_domisili',
                'name' => 'Alamat Domisili',
            ],
            [
                'key' => 'alamat_sesuai_ktp',
                'name' => 'Alamat Sesuai KTP',
            ],
            [
                'key' => 'status',
                'name' => 'Status',
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return UserRepository::datatable(null);
    }

    public function getView(): string
    {
        return 'livewire.employee.employee.datatable';
    }
}
