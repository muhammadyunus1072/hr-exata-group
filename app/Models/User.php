<?php

namespace App\Models;

use App\Models\Employee\EmployeeAdditionalInformation;
use App\Models\Employee\EmployeeDrink;
use App\Models\Employee\EmployeeEmergencyContact;
use App\Models\Employee\EmployeeFood;
use App\Models\Employee\EmployeeHobby;
use App\Models\Employee\EmployeeOfficeEmail;
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
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, HasTrackHistory;

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
        'jenis_kelamin',
        'agama',
        'status_perkawinan',
        'pendidikan_terakhir',
        'jenis_apresiasi',
        'keterangan_apresiasi',

        // Contact Information
        'no_telp_pribadi',
        'no_telp_kantor',
        'email_pribadi',

        // Address Information
        'alamat_domisili',
        'alamat_sesuai_ktp',

        'status',
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

    const JENIS_KELAMIN_L = 'Laki-laki';
    const JENIS_KELAMIN_P = 'Perempuan';

    const JENIS_KELAMIN_CHOICE = [
        self::JENIS_KELAMIN_L => "Laki-laki",
        self::JENIS_KELAMIN_P => "Perempuan",
    ];

    const STATUS_PERKAWINAN_KAWIN = 'Kawin';
    const STATUS_PERKAWINAN_BELUM_KAWIN = 'Belum Kawin';

    const STATUS_PERKAWINAN_CHOICE = [
        self::STATUS_PERKAWINAN_KAWIN => "Kawin",
        self::STATUS_PERKAWINAN_BELUM_KAWIN => "Belum Kawin",
    ];

    const APPRECIATION_JALAN_JALAN = 'Jalan-jalan';
    const APPRECIATION_STAYCATION = 'Staycation';
    const APPRECIATION_LIBUR = 'Libur';
    const APPRECIATION_HADIAH = 'Hadiah';

    const APPRECIATION_CHOICE = [
        self::APPRECIATION_JALAN_JALAN => 'Jalan-jalan',
        self::APPRECIATION_STAYCATION => 'Staycation',
        self::APPRECIATION_LIBUR => 'Libur',
        self::APPRECIATION_HADIAH => 'Hadiah',
    ];

    const STATUS_ACTIVE = 'Aktif';
    const STATUS_NON_ACTIVE = 'Tidak Aktif';

    const ADDITIONAL_INFORMATION_KK = 'KK';
    const ADDITIONAL_INFORMATION_AKTA_KELAHIRAN = 'AKTA KELAHIRAN';
    const ADDITIONAL_INFORMATION_IJAZAH = 'IJAZAH';
    const ADDITIONAL_INFORMATION_BPJS_TK = 'BPJS TK';
    const ADDITIONAL_INFORMATION_KTP = 'KTP';
    const ADDITIONAL_INFORMATION_NPWP = 'NPWP';


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

    public function employeeOfficeEmails()
    {
        return $this->hasMany(EmployeeOfficeEmail::class, 'user_id', 'id');
    }

    public function employeeEmergencyContacts()
    {
        return $this->hasMany(EmployeeEmergencyContact::class, 'user_id', 'id');
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
}
