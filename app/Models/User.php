<?php

namespace App\Models;

use App\Helpers\GlobalHelper;
use App\Models\Company\CompanyAsset;
use App\Models\Employee\EmployeeAdditionalInformation;
use App\Models\Employee\EmployeeAdministrativeCareer;
use App\Models\Employee\EmployeeAssessmentReport;
use App\Models\Employee\EmployeeCompanyAccount;
use App\Models\Employee\EmployeeDrink;
use App\Models\Employee\EmployeeEmergencyContact;
use App\Models\Employee\EmployeeFood;
use App\Models\Employee\EmployeeHobby;
use App\Traits\Models\UppercaseAttributes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, HasTrackHistory, UppercaseAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',


        //----------//
        // EMPLOYEE //
        //----------//
        'nomor_karyawan',

        // Personal Information
        'nomor_identitas',
        'tempat_lahir',
        'tanggal_lahir',
        'zodiac',
        'jenis_kelamin',
        'agama',
        'status_perkawinan',
        'pendidikan_terakhir',
        'keterangan_pendidikan_terakhir',
        'golongan_darah',
        'jenis_apresiasi',
        'keterangan_apresiasi',
        'divisi',
        'nama_bank',
        'no_rekening',

        // Contact Information
        'no_telp_pribadi',
        'no_telp_kantor',
        'tenggat_waktu_pembayaran',

        // Address Information
        'alamat_domisili',
        'alamat_sesuai_ktp',

        'tanggal_masuk',
        'tanggal_keluar',
        'alasan_keluar',
        'last_employee_career_id',
    ];

    protected array $uppercase = [
        'name',
        'username',
        'tempat_lahir',
        'keterangan_pendidikan_terakhir'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function onBoot()
    {
        self::saving(function ($model) {
            if ($model->isDirty('tanggal_lahir')) {
                $model->zodiac = GlobalHelper::getZodiacFromDate($model->tanggal_lahir);
                logger($model->zodiac);
            }
        });
    }

    const PASSWORD_DEFAULT = "EXATA2026";

    const AGAMA_ISLAM = 'Islam';
    const AGAMA_KRISTEN = 'Kristen';
    const AGAMA_KATOLIK = 'Katolik';
    const AGAMA_HINDU = 'Hindu';
    const AGAMA_BUDDHA = 'Buddha';
    const AGAMA_KONGHUCU = 'Konghucu';

    const AGAMA_CHOICE = [
        self::AGAMA_ISLAM => 'Islam',
        self::AGAMA_KRISTEN => 'Kristen',
        self::AGAMA_KATOLIK => 'Katolik',
        self::AGAMA_HINDU => 'Hindu',
        self::AGAMA_BUDDHA => 'Buddha',
        self::AGAMA_KONGHUCU => 'Konghucu',
    ];
    const PENDIDIKAN_TERAKHIR_SD = 'SD / Sederajat';
    const PENDIDIKAN_TERAKHIR_SMP = 'SMP / Sederajat';
    const PENDIDIKAN_TERAKHIR_SMA = 'SMA / SMK / Sederajat';
    const PENDIDIKAN_TERAKHIR_D1 = 'Diploma 1 (D1)';
    const PENDIDIKAN_TERAKHIR_D2 = 'Diploma 2 (D2)';
    const PENDIDIKAN_TERAKHIR_D3 = 'Diploma 3 (D3)';
    const PENDIDIKAN_TERAKHIR_D4 = 'Diploma 4 (D4)';
    const PENDIDIKAN_TERAKHIR_S1 = 'Sarjana (S1)';
    const PENDIDIKAN_TERAKHIR_S2 = 'Magister (S2)';
    const PENDIDIKAN_TERAKHIR_S3 = 'Doktor (S3)';

    const PENDIDIKAN_TERAKHIR_CHOICE = [
        self::PENDIDIKAN_TERAKHIR_SD => 'SD / Sederajat',
        self::PENDIDIKAN_TERAKHIR_SMP => 'SMP / Sederajat',
        self::PENDIDIKAN_TERAKHIR_SMA => 'SMA / SMK / Sederajat',
        self::PENDIDIKAN_TERAKHIR_D1 => 'Diploma 1 (D1)',
        self::PENDIDIKAN_TERAKHIR_D2 => 'Diploma 2 (D2)',
        self::PENDIDIKAN_TERAKHIR_D3 => 'Diploma 3 (D3)',
        self::PENDIDIKAN_TERAKHIR_D4 => 'Diploma 4 (D4)',
        self::PENDIDIKAN_TERAKHIR_S1 => 'Sarjana (S1)',
        self::PENDIDIKAN_TERAKHIR_S2 => 'Magister (S2)',
        self::PENDIDIKAN_TERAKHIR_S3 => 'Doktor (S3)',
    ];

    const GOLONGAN_DARAH_TIDAK_DIKETAHUI = '';
    const GOLONGAN_DARAH_A = 'A';
    const GOLONGAN_DARAH_B = 'B';
    const GOLONGAN_DARAH_AB = 'AB';
    const GOLONGAN_DARAH_O = 'O';

    const GOLONGAN_DARAH_CHOICE = [
        self::GOLONGAN_DARAH_TIDAK_DIKETAHUI => "Tidak Diketahui",
        self::GOLONGAN_DARAH_A => "A",
        self::GOLONGAN_DARAH_B => "B",
        self::GOLONGAN_DARAH_AB => "AB",
        self::GOLONGAN_DARAH_O => "O",
    ];

    const JENIS_KELAMIN_L = 'LAKI-LAKI';
    const JENIS_KELAMIN_P = 'PEREMPUAN';

    const JENIS_KELAMIN_CHOICE = [
        self::JENIS_KELAMIN_L => "LAKI-LAKI",
        self::JENIS_KELAMIN_P => "PEREMPUAN",
    ];

    const STATUS_PERKAWINAN_KAWIN = 'Kawin';
    const STATUS_PERKAWINAN_BELUM_KAWIN = 'Belum Kawin';

    const STATUS_PERKAWINAN_CHOICE = [
        self::STATUS_PERKAWINAN_KAWIN => "Kawin",
        self::STATUS_PERKAWINAN_BELUM_KAWIN => "Belum Kawin",
    ];

    const NAMA_BANK_BCA = 'BCA';
    const NAMA_BANK_MANDIRI = 'MANDIRI';
    const NAMA_BANK_BRI = 'BRI';
    const NAMA_BANK_BNI = 'BNI';
    const NAMA_BANK_LAINNYA = 'LAINNYA';

    const NAMA_BANK_CHOICE = [
        self::NAMA_BANK_BCA => "BCA",
        self::NAMA_BANK_MANDIRI => "MANDIRI",
        self::NAMA_BANK_BRI => "BRI",
        self::NAMA_BANK_BNI => "BNI",
        self::NAMA_BANK_LAINNYA => "LAINNYA",
    ];

    const DIVISI_EXATA = 'SUMBER REZEKI EXATA INDONESIA';
    const DIVISI_YANOSHI = 'YANOSHI JAPAN OMIYAGE';
    const DIVISI_TRAVEL = 'JAPANINDO TRAVEL CONNECTION';
    const DIVISI_J_EXPERT = 'J-EXPERT';

    const DIVISI_CHOICE = [
        self::DIVISI_EXATA => "SUMBER REZEKI EXATA INDONESIA",
        self::DIVISI_YANOSHI => "YANOSHI JAPAN OMIYAGE",
        self::DIVISI_TRAVEL => "JAPANINDO TRAVEL CONNECTION",
        self::DIVISI_J_EXPERT => "J-EXPERT",
    ];

    const APPRECIATION_JALAN_JALAN = 'Jalan-jalan';
    const APPRECIATION_STAYCATION = 'Staycation';
    const APPRECIATION_HADIAH = 'Hadiah';
    const APPRECIATION_LAINNYA = 'Lainnya';

    const APPRECIATION_CHOICE = [
        self::APPRECIATION_JALAN_JALAN => 'Jalan-jalan',
        self::APPRECIATION_STAYCATION => 'Staycation',
        self::APPRECIATION_HADIAH => 'Hadiah',
        self::APPRECIATION_LAINNYA => 'Lainnya',
    ];

    const STATUS_ACTIVE = 'Aktif';
    const STATUS_NON_ACTIVE = 'Tidak Aktif';

    const ADDITIONAL_INFORMATION_KK = 'KK';
    const ADDITIONAL_INFORMATION_AKTA_KELAHIRAN = 'AKTA KELAHIRAN';
    const ADDITIONAL_INFORMATION_IJAZAH = 'IJAZAH';
    const ADDITIONAL_INFORMATION_BPJS_TK = 'BPJS TK';
    const ADDITIONAL_INFORMATION_KTP = 'KTP';
    const ADDITIONAL_INFORMATION_NPWP = 'NPWP';
    const ADDITIONAL_INFORMATION_KARTU_AXA_MANDIRI = 'Foto Kartu AXA MANDIRI';
    const ADDITIONAL_INFORMATION_SIM_A = 'SIM A';
    const ADDITIONAL_INFORMATION_SIM_C = 'SIM C';


    public function employeeAdditionalInformations()
    {
        return $this->hasMany(EmployeeAdditionalInformation::class, 'user_id', 'id');
    }

    public function employeeDrinks()
    {
        return $this->hasMany(EmployeeDrink::class, 'user_id', 'id');
    }

    public function employeeFoods()
    {
        return $this->hasMany(EmployeeFood::class, 'user_id', 'id');
    }

    public function employeeHobbies()
    {
        return $this->hasMany(EmployeeHobby::class, 'user_id', 'id');
    }

    public function employeeCompanyAccounts()
    {
        return $this->hasMany(EmployeeCompanyAccount::class, 'user_id', 'id');
    }

    public function employeeEmergencyContacts()
    {
        return $this->hasMany(EmployeeEmergencyContact::class, 'user_id', 'id');
    }

    public function employeeAdministrativeCareers()
    {
        return $this->hasMany(EmployeeAdministrativeCareer::class, 'user_id', 'id');
    }

    public function employeeAssessmentReports()
    {
        return $this->hasMany(EmployeeAssessmentReport::class, 'user_id', 'id');
    }

    public function companyAssets()
    {
        return $this->hasMany(CompanyAsset::class, 'assigned_user_id', 'id');
    }

    public function employeeAdditionalInformationKK()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_KK);
    }
    public function employeeAdditionalInformationAktaKelahiran()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_AKTA_KELAHIRAN);
    }
    public function employeeAdditionalInformationIjazah()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_IJAZAH);
    }
    public function employeeAdditionalInformationBPJSTK()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_BPJS_TK);
    }
    public function employeeAdditionalInformationKTP()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_KTP);
    }
    public function employeeAdditionalInformationNPWP()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_NPWP);
    }
    public function employeeAdditionalInformationKartuAxaMandiri()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_KARTU_AXA_MANDIRI);
    }
    public function employeeAdditionalInformationSimA()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_SIM_A);
    }
    public function employeeAdditionalInformationSimC()
    {
        return $this->hasOne(EmployeeAdditionalInformation::class, 'user_id')
            ->where('deskripsi', self::ADDITIONAL_INFORMATION_SIM_C);
    }
}
