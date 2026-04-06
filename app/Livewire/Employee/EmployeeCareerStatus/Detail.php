<?php

namespace App\Livewire\Employee\EmployeeCareerStatus;

use App\Helpers\Alert;
use App\Repositories\Employee\EmployeeCareerStatusRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Detail extends Component
{

    public $objId;

    public $employee_career_statuses = [];

    public function mount()
    {
        $employee_career_status = EmployeeCareerStatusRepository::all();
        foreach ($employee_career_status as $career_status) {
            $this->employee_career_statuses[] = [
                'name' => $career_status->name,
                'level' => $career_status->level,
            ];
        }
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('employee_career_status.edit', $this->objId);
        } else {
            $this->redirectRoute('employee_career_status.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('employee_career_status.index');
    }

    public function addEmergencyContact()
    {
        $this->emergency_contacts[] = [
            'id' => '',
            'name' => '',
            'level' => '',
        ];
    }

    public function removeEmergencyContact($index)
    {

        if ($this->emergency_contacts[$index]['id']) {
            $this->emergency_contact_removes[] = $this->emergency_contacts[$index]['id'];
        }
        unset($this->emergency_contacts[$index]);
    }

    public function store()
    {
        try {
            DB::transaction(function () {
                $employee_id = null;
                $validateData = [
                    'name' => $this->name,
                    'level' => $this->level,
                ];
                if ($this->objId) {

                    EmployeeCareerStatusRepository::update(Crypt::decrypt($this->objId), $validateData);
                } else {
                    EmployeeCareerStatusRepository::create($validateData);
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
        return view('livewire.employee.employee-career-status.detail');
    }
}
