<?php

namespace App\Livewire\Auth;

use App\Helpers\Alert;
use App\Helpers\FilePathHelper;
use App\Models\Employee\EmployeeAdditionalInformation;
use App\Models\User;
use App\Repositories\Account\UserRepository;
use App\Repositories\Employee\EmployeeAdditionalInformationRepository;
use App\Repositories\Employee\EmployeeDrinkRepository;
use App\Repositories\Employee\EmployeeEmergencyContactRepository;
use App\Repositories\Employee\EmployeeFoodRepository;
use App\Repositories\Employee\EmployeeHobbyRepository;
use App\Repositories\Employee\EmployeeOfficeEmailRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    #[Validate('required', message: 'Nama Harus Diisi', onUpdate: false)]
    public $name;

    public $username;
    public $email;
    public $role;

    public $oldPassword;
    public $password;
    public $retypePassword;

    public $nomor_karyawan;

    // Personal Information
    public $nama_karyawan;
    public $nomor_identitas;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $agama;
    public $status_perkawinan;
    public $pendidikan_terakhir;

    public $makanan;
    public $minuman;
    public $hobi;
    public $jenis_apresiasi;
    public $keterangan_apresiasi;

    // Contact Information
    public $no_telp_pribadi;
    public $no_telp_kantor;
    public $email_pribadi;

    // Address Information
    public $alamat_domisili;
    public $alamat_sesuai_ktp;

    public $email_kantors = [];
    public $email_kantor_removes = [];

    // Additional Information
    public $additional_kk;
    public $additional_akta_kelahiran;
    public $additional_ijazah;
    public $additional_bpjs_tk;
    public $additional_ktp;
    public $additional_npwp;

    public $additional_kk_old;
    public $additional_akta_kelahiran_old;
    public $additional_ijazah_old;
    public $additional_bpjs_tk_old;
    public $additional_ktp_old;
    public $additional_npwp_old;

    public $status = false;

    // Emergency Contact
    public $emergency_contacts = [];
    public $emergency_contact_removes = [];

    public function mount()
    {
        $employee = UserRepository::authenticatedUser();
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->username = $employee->username;
        $this->role = $employee->roles[0]->name;

        $this->nomor_karyawan = $employee->nomor_karyawan;

        // Personal Information
        $this->nama_karyawan = $employee->nama_karyawan;
        $this->nomor_identitas = $employee->nomor_identitas;
        $this->tempat_lahir = $employee->tempat_lahir;
        $this->tanggal_lahir = $employee->tanggal_lahir;
        $this->jenis_kelamin = $employee->jenis_kelamin;
        $this->agama = $employee->agama;
        $this->status_perkawinan = $employee->status_perkawinan;
        $this->pendidikan_terakhir = $employee->pendidikan_terakhir;

        $this->makanan = $employee->makanan;
        $this->minuman = $employee->minuman;
        $this->hobi = $employee->hobi;
        $this->jenis_apresiasi = $employee->jenis_apresiasi;
        $this->keterangan_apresiasi = $employee->keterangan_apresiasi;

        // Contact Information
        $this->no_telp_pribadi = $employee->no_telp_pribadi;
        $this->no_telp_kantor = $employee->no_telp_kantor;
        $this->email_pribadi = $employee->email_pribadi;

        // Address Information
        $this->alamat_domisili = $employee->alamat_domisili;
        $this->alamat_sesuai_ktp = $employee->alamat_sesuai_ktp;

        foreach ($employee->employeeOfficeEmails as $email) {

            $this->email_kantors[] = [
                'id' => Crypt::encrypt($email->id),
                'email' => $email->email,
                'password' => $email->password,
            ];
        }
        foreach ($employee->employeeEmergencyContacts as $contact) {

            $this->emergency_contacts[] = [
                'id' => Crypt::encrypt($contact->id),
                'nama' => $contact->nama,
                'alamat' => $contact->alamat,
                'no_telp' => $contact->no_telp,
                'hubungan_keluarga' => $contact->hubungan_keluarga,
            ];
        }

        if (count($employee->employeeFoods)) {

            foreach ($employee->employeeFoods as $food) {
                $this->makanan[] = [
                    'id' => $food->id,
                    'nama' => $food->nama_makanan
                ];
            }
        } else {
            $this->makanan = [
                [
                    'id' => '',
                    'nama' => ''

                ],
                [
                    'id' => '',
                    'nama' => ''

                ],
                [
                    'id' => '',
                    'nama' => ''

                ],
            ];
        }

        if (count($employee->employeeDrinks)) {

            foreach ($employee->employeeDrinks as $drink) {
                $this->minuman[] = [
                    'id' => $drink->id,
                    'nama' => $drink->nama_minuman
                ];
            }
        } else {
            $this->minuman = [
                [
                    'id' => '',
                    'nama' => ''

                ],
                [
                    'id' => '',
                    'nama' => ''

                ],
                [
                    'id' => '',
                    'nama' => ''

                ],
            ];
        }

        if (count($employee->employeeHobbies)) {

            foreach ($employee->employeeHobbies as $hoby) {
                $this->hobi[] = [
                    'id' => $hoby->id,
                    'nama' => $hoby->nama_hobi
                ];
            }
        } else {
            $this->hobi = [
                [
                    'id' => '',
                    'nama' => ''

                ],
                [
                    'id' => '',
                    'nama' => ''

                ],
                [
                    'id' => '',
                    'nama' => ''

                ],
            ];
        }

        // Additional Information
        if ($employee->employeeAdditionalInformationKK) {

            $this->additional_kk_old = [
                'name' => $employee->employeeAdditionalInformationKK->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationKK->file)
            ];
        }
        if ($employee->employeeAdditionalInformationAktaKelahiran) {

            $this->additional_akta_kelahiran_old = [
                'name' => $employee->employeeAdditionalInformationAktaKelahiran->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationAktaKelahiran->file)
            ];
        }
        if ($employee->employeeAdditionalInformationIjazah) {

            $this->additional_ijazah_old = [
                'name' => $employee->employeeAdditionalInformationIjazah->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationIjazah->file)
            ];
        }
        if ($employee->employeeAdditionalInformationBPJSTK) {

            $this->additional_bpjs_tk_old = [
                'name' => $employee->employeeAdditionalInformationBPJSTK->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationBPJSTK->file)
            ];
        }
        if ($employee->employeeAdditionalInformationKTP) {

            $this->additional_ktp_old = [
                'name' => $employee->employeeAdditionalInformationKTP->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationKTP->file)
            ];
        }
        if ($employee->employeeAdditionalInformationNPWP) {

            $this->additional_npwp_old = [
                'name' => $employee->employeeAdditionalInformationNPWP->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationNPWP->file)
            ];
        }

        $this->status = $employee->status == User::STATUS_ACTIVE ? true : false;
    }

    public function store()
    {
        $this->validate();

        $user = UserRepository::authenticatedUser();
        $validatedData = [
            'nomor_karyawan' => $this->nomor_karyawan,

            // Personal Information
            'nama_karyawan' => $this->nama_karyawan,
            'nomor_identitas' => $this->nomor_identitas,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'status_perkawinan' => $this->status_perkawinan,
            'pendidikan_terakhir' => $this->pendidikan_terakhir,

            // Contact Information
            'no_telp_pribadi' => $this->no_telp_pribadi,
            'no_telp_kantor' => $this->no_telp_kantor,
            'email_pribadi' => $this->email_pribadi,

            // Address Information
            'alamat_domisili' => $this->alamat_domisili,
            'alamat_sesuai_ktp' => $this->alamat_sesuai_ktp,

            'makanan' => $this->makanan,
            'minuman' => $this->minuman,
            'hobi' => $this->hobi,
            'jenis_apresiasi' => $this->jenis_apresiasi,
            'keterangan_apresiasi' => $this->keterangan_apresiasi,
            'status' => $this->status ? User::STATUS_ACTIVE : User::STATUS_NON_ACTIVE,

            'name' => $this->name,
            'username' => $this->username,
        ];

        if (!empty($this->oldPassword) || !empty($this->password) || !empty($this->retypePassword)) {
            if (empty($this->oldPassword)) {
                Alert::fail($this, "Gagal", "Password Lama Harus Diisi");
                return;
            }
            if (empty($this->password)) {
                Alert::fail($this, "Gagal", "Password Baru Harus Diisi");
                return;
            }
            if (empty($this->retypePassword)) {
                Alert::fail($this, "Gagal", "Ketik Ulang Password Baru Harus Diisi");
                return;
            }
            if ($this->retypePassword != $this->password) {
                Alert::fail($this, "Gagal", "Pengetikan Ulang Password Baru Tidak Sama");
                return;
            }
            if (!Hash::check($this->oldPassword, $user->password)) {
                Alert::fail($this, 'Gagal', 'Password Lama Tidak Sesuai');
                return;
            }

            $validatedData['password'] = Hash::make($this->password);
        }

        try {
            DB::beginTransaction();
            UserRepository::update($user->id, $validatedData);


            foreach ($this->email_kantors as $mail) {
                $validatedOfficeEmail = [
                    'user_id' => $user->id,
                    'email' => $mail['email'],
                    'password' => $mail['password'],
                ];
                $this->dispatch('consoleLog', $validatedOfficeEmail);
                if ($mail['id']) {

                    EmployeeOfficeEmailRepository::update(Crypt::decrypt($mail['id']), $validatedOfficeEmail);
                } else {

                    EmployeeOfficeEmailRepository::create($validatedOfficeEmail);
                }
            }

            foreach ($this->email_kantor_removes as $email_remove) {
                EmployeeOfficeEmailRepository::delete(Crypt::decrypt($email_remove));
            }

            foreach ($this->emergency_contacts as $mail) {
                $validatedEmergencyContact = [
                    'user_id' => $user->id,
                    'nama' => $mail['nama'],
                    'alamat' => $mail['alamat'],
                    'no_telp' => $mail['no_telp'],
                    'hubungan_keluarga' => $mail['hubungan_keluarga'],
                ];
                $this->dispatch('consoleLog', $validatedEmergencyContact);
                if ($mail['id']) {

                    EmployeeEmergencyContactRepository::update(Crypt::decrypt($mail['id']), $validatedEmergencyContact);
                } else {

                    EmployeeEmergencyContactRepository::create($validatedEmergencyContact);
                }
            }

            foreach ($this->emergency_contact_removes as $contact_remove) {
                EmployeeEmergencyContactRepository::delete(Crypt::decrypt($contact_remove));
            }

            foreach ($this->makanan as $makanan) {
                $validatedFood = [
                    'user_id' => $user->id,
                    'nama_makanan' => $makanan['nama'],
                ];
                $this->dispatch('consoleLog', $validatedFood);
                if ($makanan['id']) {

                    EmployeeFoodRepository::update($makanan['id'], $validatedFood);
                } else {
                    EmployeeFoodRepository::create($validatedFood);
                }
            }
            foreach ($this->minuman as $minuman) {
                $validatedFood = [
                    'user_id' => $user->id,
                    'nama_minuman' => $minuman['nama'],
                ];
                $this->dispatch('consoleLog', $validatedFood);
                if ($minuman['id']) {

                    EmployeeDrinkRepository::update($minuman['id'], $validatedFood);
                } else {
                    EmployeeDrinkRepository::create($validatedFood);
                }
            }
            foreach ($this->hobi as $hobi) {
                $validatedFood = [
                    'user_id' => $user->id,
                    'nama_hobi' => $hobi['nama'],
                ];
                $this->dispatch('consoleLog', $validatedFood);
                if ($hobi['id']) {

                    EmployeeHobbyRepository::update($hobi['id'], $validatedFood);
                } else {
                    EmployeeHobbyRepository::create($validatedFood);
                }
            }
            // KK //
            if ($this->additional_kk) {

                $path = $this->additional_kk->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_KK,
                    'nama_dokumen' => $this->additional_kk->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformation::updateOrCreate([
                    'user_id' => $user->id,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_KK,

                ], $validatedAdditional);
            }
            // AKTA KELAHIRAN //
            if ($this->additional_akta_kelahiran) {

                $path = $this->additional_akta_kelahiran->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_AKTA_KELAHIRAN,
                    'nama_dokumen' => $this->additional_akta_kelahiran->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformation::updateOrCreate([
                    'user_id' => $user->id,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_AKTA_KELAHIRAN,

                ], $validatedAdditional);
            }
            // IJAZAH //
            if ($this->additional_ijazah) {

                $path = $this->additional_ijazah->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_IJAZAH,
                    'nama_dokumen' => $this->additional_ijazah->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformation::updateOrCreate([
                    'user_id' => $user->id,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_IJAZAH,

                ], $validatedAdditional);
            }
            // BPJS TK //
            if ($this->additional_bpjs_tk) {

                $path = $this->additional_bpjs_tk->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_BPJS_TK,
                    'nama_dokumen' => $this->additional_bpjs_tk->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformation::updateOrCreate([
                    'user_id' => $user->id,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_BPJS_TK,

                ], $validatedAdditional);
            }
            // KTP //
            if ($this->additional_ktp) {

                $path = $this->additional_ktp->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_KTP,
                    'nama_dokumen' => $this->additional_ktp->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformation::updateOrCreate([
                    'user_id' => $user->id,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_KTP,

                ], $validatedAdditional);
            }
            // NPWP //
            if ($this->additional_npwp) {

                $path = $this->additional_npwp->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_NPWP,
                    'nama_dokumen' => $this->additional_npwp->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformation::updateOrCreate([
                    'user_id' => $user->id,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_NPWP,

                ], $validatedAdditional);
            }
            Alert::success($this, 'Berhasil', 'Profil berhasil diperbarui');
            DB::commit();

            $this->redirectRoute('profile');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
}
