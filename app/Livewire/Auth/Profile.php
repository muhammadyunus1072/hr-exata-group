<?php

namespace App\Livewire\Auth;

use App\Helpers\Alert;
use App\Helpers\FilePathHelper;
use App\Models\Employee\EmployeeAdditionalInformation;
use App\Models\User;
use App\Repositories\Account\UserRepository;
use App\Repositories\Employee\EmployeeAdditionalInformationRepository;
use App\Repositories\Employee\EmployeeAdministrativeCareerRepository;
use App\Repositories\Employee\EmployeeAssessmentReportRepository;
use App\Repositories\Employee\EmployeeCompanyAccountRepository;
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
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $username;
    public $role;
    public $oldPassword;
    public $password;
    public $retypePassword;

    public $nomor_karyawan;

    // Personal Information
    public $name;
    public $nomor_identitas;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $zodiac;
    public $jenis_kelamin;
    public $agama;
    public $status_perkawinan;
    public $pendidikan_terakhir;
    public $keterangan_pendidikan_terakhir;
    public $golongan_darah = User::GOLONGAN_DARAH_TIDAK_DIKETAHUI;
    public $divisi;
    public $nama_bank;
    public $no_rekening;

    public $makanan;
    public $minuman;
    public $hobi;
    public $jenis_apresiasi;
    public $keterangan_apresiasi;

    // Contact Information
    public $no_telp_pribadi;
    public $email;
    public $no_telp_kantor;
    public $tenggat_waktu_pembayaran;

    // Address Information
    public $alamat_domisili;
    public $alamat_sesuai_ktp;

    // Additional Information
    public $additional_kk;
    public $additional_akta_kelahiran;
    public $additional_ijazah;
    public $additional_bpjs_tk;
    public $additional_ktp;
    public $additional_npwp;
    public $additional_sim_a;
    public $additional_sim_c;
    public $additional_kartu_axa_mandiri;

    public $additional_kk_old;
    public $additional_akta_kelahiran_old;
    public $additional_ijazah_old;
    public $additional_bpjs_tk_old;
    public $additional_ktp_old;
    public $additional_npwp_old;
    public $additional_sim_a_old;
    public $additional_sim_c_old;
    public $additional_kartu_axa_mandiri_old;

    public $status = false;

    // Emergency Contact
    public $emergency_contacts = [];
    public $emergency_contact_removes = [];

    // Administration Career
    public $tanggal_masuk;
    public $tanggal_keluar;
    public $alasan_keluar;
    public $administration_careers = [];
    public $administration_career_removes = [];

    // Company Account
    public $company_accounts = [];
    public $company_account_removes = [];

    // Company Asset
    public $company_assets = [];

    // Assessment Report
    public $assessment_reports = [];
    public $assessment_report_removes = [];

    public function mount()
    {
        $employee = UserRepository::authenticatedUser();
        $this->email = $employee->email;
        $this->username = $employee->username;
        $this->role = $employee->roles[0]->name;

        $this->nomor_karyawan = $employee->nomor_karyawan;

        // Personal Information
        $this->name = $employee->name;
        $this->nomor_identitas = $employee->nomor_identitas;
        $this->tempat_lahir = $employee->tempat_lahir;
        $this->tanggal_lahir = $employee->tanggal_lahir;
        $this->zodiac = $employee->zodiac ?? '-';
        $this->jenis_kelamin = $employee->jenis_kelamin;
        $this->agama = $employee->agama;
        $this->status_perkawinan = $employee->status_perkawinan;
        $this->pendidikan_terakhir = $employee->pendidikan_terakhir;
        $this->keterangan_pendidikan_terakhir = $employee->keterangan_pendidikan_terakhir;
        $this->golongan_darah = $employee->golongan_darah;
        $this->divisi = $employee->divisi;
        $this->nama_bank = $employee->nama_bank;
        $this->no_rekening = $employee->no_rekening;

        $this->makanan = $employee->makanan;
        $this->minuman = $employee->minuman;
        $this->hobi = $employee->hobi;
        $this->jenis_apresiasi = $employee->jenis_apresiasi;
        $this->keterangan_apresiasi = $employee->keterangan_apresiasi;

        // Contact Information
        $this->no_telp_pribadi = $employee->no_telp_pribadi;
        $this->no_telp_kantor = $employee->no_telp_kantor;
        $this->email = $employee->email;
        $this->tenggat_waktu_pembayaran = $employee->tenggat_waktu_pembayaran;

        // Address Information
        $this->alamat_domisili = $employee->alamat_domisili;
        $this->alamat_sesuai_ktp = $employee->alamat_sesuai_ktp;

        // Administration Careed
        $this->tanggal_masuk = $employee->tanggal_masuk;
        $this->tanggal_keluar = $employee->tanggal_keluar;
        $this->alasan_keluar = $employee->alasan_keluar;

        foreach ($employee->employeeAdministrativeCareers as $administrative_career) {
            $this->administration_careers[] = [
                'id' => Crypt::encrypt($administrative_career->id),
                'nama_dokumen' => $administrative_career->nama_dokumen,
                'file' => $administrative_career->file,
                'deskripsi' => $administrative_career->deskripsi,
                'url' => Storage::url($administrative_career->file),
            ];
        }

        foreach ($employee->employeeAssessmentReports as $report) {
            $this->assessment_reports[] = [
                'id' => Crypt::encrypt($report->id),
                'nama_dokumen' => $report->nama_dokumen,
                'file' => $report->file,
                'type' => $report->type,
                'deskripsi' => $report->deskripsi,
                'url' => Storage::url($report->file),
            ];
        }

        foreach ($employee->employeeCompanyAccounts as $account) {

            $this->company_accounts[] = [
                'id' => Crypt::encrypt($account->id),
                'platform' => $account->platform,
                'username' => $account->username,
                'password' => $account->password,
                'catatan' => $account->catatan,
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
        foreach ($employee->companyAssets as $asset) {

            $this->company_assets[] = [
                'id' => Crypt::encrypt($asset->id),
                'assigned_at' => $asset->assigned_at,
                'nama_barang' => $asset->nama_barang,
                'serial_number' => $asset->serial_number ?? '-',
                'status_barang' => $asset->status_barang,
                'status_kondisi' => $asset->status_kondisi,
                'status_pembelian' => $asset->status_pembelian,
                'divisi' => $asset->divisi,
                'brand' => $asset->brand,
                'keterangan' => $asset->keterangan,
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

        if ($employee->employeeAdditionalInformationSimA) {

            $this->additional_sim_a_old = [
                'name' => $employee->employeeAdditionalInformationSimA->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationSimA->file)
            ];
        }
        if ($employee->employeeAdditionalInformationSimC) {

            $this->additional_sim_c_old = [
                'name' => $employee->employeeAdditionalInformationSimC->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationSimC->file)
            ];
        }
        if ($employee->employeeAdditionalInformationKartuAxaMandiri) {

            $this->additional_kartu_axa_mandiri_old = [
                'name' => $employee->employeeAdditionalInformationKartuAxaMandiri->nama_dokumen,
                'url' => Storage::url($employee->employeeAdditionalInformationKartuAxaMandiri->file)
            ];
        }

        $this->status = $employee->status == User::STATUS_ACTIVE ? true : false;
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        $this->redirectRoute('profile');
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('profile');
    }

    public function addEmailKantor()
    {
        $this->email_kantors[] = [
            'id' => '',
            'email' => '',
            'password' => ''
        ];
    }

    public function removeEmailKantor($index)
    {

        if ($this->email_kantors[$index]['id']) {
            $this->email_kantor_removes[] = $this->email_kantors[$index]['id'];
        }
        unset($this->email_kantors[$index]);
    }

    public function addEmergencyContact()
    {
        $this->emergency_contacts[] = [
            'id' => '',
            'name' => '',
            'alamat' => '',
            'no_telp' => '',
            'hubungan_keluarga' => ''
        ];
    }

    public function removeEmergencyContact($index)
    {

        if ($this->emergency_contacts[$index]['id']) {
            $this->emergency_contact_removes[] = $this->emergency_contacts[$index]['id'];
        }
        unset($this->emergency_contacts[$index]);
    }

    public function addAdministrationCareer()
    {
        $this->administration_careers[] = [
            'id' => '',
            'nama_dokumen' => '',
            'deskripsi' => '',
            'file' => '',
            'url' => '',
        ];
    }

    public function removeAdministrationCareer($index)
    {

        if ($this->administration_careers[$index]['id']) {
            $this->administration_career_removes[] = $this->administration_careers[$index]['id'];
        }
        unset($this->administration_careers[$index]);
    }

    public function addAssessmentReport()
    {
        $this->assessment_reports[] = [
            'id' => '',
            'nama_dokumen' => '',
            'deskripsi' => '',
            'file' => '',
            'type' => '',
            'url' => '',
        ];
    }

    public function removeAssessmentReport($index)
    {

        if ($this->assessment_reports[$index]['id']) {
            $this->assessment_report_removes[] = $this->assessment_reports[$index]['id'];
        }
        unset($this->assessment_reports[$index]);
    }

    public function addCompanyAccount()
    {
        $this->company_accounts[] = [
            'id' => '',
            'platform' => '',
            'username' => '',
            'password' => '',
            'catatan' => '',
        ];
    }

    public function removeCompanyAccount($index)
    {

        if ($this->company_accounts[$index]['id']) {
            $this->company_account_removes[] = $this->company_accounts[$index]['id'];
        }
        unset($this->company_accounts[$index]);
    }

    public function store()
    {
        $validateData = [
            'nomor_karyawan' => $this->nomor_karyawan,

            // Profile
            'name' => $this->name,
            'username' => $this->username,

            // Personal Information
            'nomor_identitas' => $this->nomor_identitas,
            'divisi' => $this->divisi,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'status_perkawinan' => $this->status_perkawinan,
            'pendidikan_terakhir' => $this->pendidikan_terakhir,
            'keterangan_pendidikan_terakhir' => $this->keterangan_pendidikan_terakhir,
            'golongan_darah' => $this->golongan_darah,

            // Contact Information
            'no_telp_pribadi' => $this->no_telp_pribadi,
            'no_telp_kantor' => $this->no_telp_kantor,
            'tenggat_waktu_pembayaran' => $this->tenggat_waktu_pembayaran,
            'email' => $this->email,
            // 'password' => User::PASSWORD_DEFAULT,

            // Address Information
            'alamat_domisili' => $this->alamat_domisili,
            'alamat_sesuai_ktp' => $this->alamat_sesuai_ktp,

            'makanan' => $this->makanan,
            'minuman' => $this->minuman,
            'hobi' => $this->hobi,
            'jenis_apresiasi' => $this->jenis_apresiasi,
            'keterangan_apresiasi' => $this->keterangan_apresiasi,

            // Administration Careed
            'tanggal_masuk' => $this->tanggal_masuk,
            'tanggal_keluar' => $this->tanggal_keluar,
            'alasan_keluar' => $this->alasan_keluar,

        ];

        $user = UserRepository::authenticatedUser();

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

            UserRepository::update($user->id, $validateData);

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
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
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
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
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
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
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
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
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
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
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
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
            }
            // SIM A //
            if ($this->additional_sim_a) {

                $path = $this->additional_sim_a->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_SIM_A,
                    'nama_dokumen' => $this->additional_sim_a->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
            }
            // SIM C //
            if ($this->additional_sim_c) {

                $path = $this->additional_sim_c->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_SIM_C,
                    'nama_dokumen' => $this->additional_sim_c->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
            }
            // SIM A //
            if ($this->additional_kartu_axa_mandiri) {

                $path = $this->additional_kartu_axa_mandiri->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');
                $validatedAdditional = [
                    'user_id' => $user->id,
                    'file' => $path,
                    'deskripsi' => User::ADDITIONAL_INFORMATION_KARTU_AXA_MANDIRI,
                    'nama_dokumen' => $this->additional_kartu_axa_mandiri->getClientOriginalName()
                ];
                $this->dispatch('consoleLog', $validatedAdditional);
                EmployeeAdditionalInformationRepository::create($validatedAdditional);
            }
            // Administration Career
            foreach ($this->administration_careers as $administration_career) {

                $data = [
                    'user_id'   => $user->id,
                    'deskripsi' => $administration_career['deskripsi'],
                ];

                /**
                 * Upload file jika ada file baru
                 */
                if (
                    !empty($administration_career['file'])
                    && $administration_career['file'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                ) {

                    $path = $administration_career['file']
                        ->store(FilePathHelper::FILE_EMPLOYEE_ADDITIONAL_INFORMATION, 'public');

                    $data['file'] = $path;
                    $data['nama_dokumen'] = $administration_career['file']->getClientOriginalName();
                }

                /**
                 * Update atau Create
                 */
                if ($administration_career['id']) {

                    EmployeeAdministrativeCareerRepository::update(
                        Crypt::decrypt($administration_career['id']),
                        $data
                    );
                } else {
                    EmployeeAdministrativeCareerRepository::create($data);
                }
            }

            foreach ($this->administration_career_removes as $item) {
                EmployeeAdministrativeCareerRepository::delete(Crypt::decrypt($item));
            }
            // Assessment Report
            foreach ($this->assessment_reports as $assessment_report) {

                $data = [
                    'user_id'   => $user->id,
                    'deskripsi' => $assessment_report['deskripsi'],
                    'type' => $assessment_report['type'],
                ];

                /**
                 * Upload file jika ada file baru
                 */
                if (
                    !empty($assessment_report['file'])
                    && $assessment_report['file'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                ) {

                    $path = $assessment_report['file']
                        ->store(FilePathHelper::FILE_EMPLOYEE_ASSESSMENT_REPORT, 'public');

                    $data['file'] = $path;
                    $data['nama_dokumen'] = $assessment_report['file']->getClientOriginalName();
                }

                /**
                 * Update atau Create
                 */
                if ($assessment_report['id']) {

                    EmployeeAssessmentReportRepository::update(
                        Crypt::decrypt($assessment_report['id']),
                        $data
                    );
                } else {
                    EmployeeAssessmentReportRepository::create($data);
                }
            }

            foreach ($this->assessment_report_removes as $item) {
                EmployeeAssessmentReportRepository::delete(Crypt::decrypt($item));
            }

            // Company Account 

            foreach ($this->company_accounts as $mail) {
                $validatedData = [
                    'user_id' => $user->id,
                    'platform' => $mail['platform'],
                    'username' => $mail['username'],
                    'password' => $mail['password'],
                    'catatan' => $mail['catatan'],
                ];
                $this->dispatch('consoleLog', $validatedData);
                if ($mail['id']) {
                    EmployeeCompanyAccountRepository::update(Crypt::decrypt($mail['id']), $validatedData);
                } else {
                    EmployeeCompanyAccountRepository::create($validatedData);
                }
            }

            foreach ($this->company_account_removes as $acount_remove) {
                EmployeeCompanyAccountRepository::delete(Crypt::decrypt($acount_remove));
            }



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
        return view('livewire.auth.profile');
    }
}
