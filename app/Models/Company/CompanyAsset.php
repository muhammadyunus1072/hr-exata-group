<?php

namespace App\Models\Company;

use App\Models\User;
use App\Repositories\Company\CompanyAssetHistoryRepository;
use App\Traits\Models\UppercaseAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class CompanyAsset extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory, UppercaseAttributes;

    protected $fillable = [

        'assigned_user_id',
        'assigned_user_name',
        'assigned_at',
        'nama_barang',
        'jenis',
        'serial_number',
        'password',
        'divisi',
        'brand',
        'keterangan',
        'status_barang',
        'status_kondisi',
        'status_pembelian',
    ];

    protected array $uppercase = [
        'assigned_user_name',
        'nama_barang',
        'serial_number',
        'brand',
    ];

    protected $guarded = ['id'];

    public function isDeletable()
    {
        return true;
    }

    public function isEditable()
    {
        return true;
    }

    protected static function onBoot()
    {
        self::saving(function ($model) {
            if ($model->isDirty('assigned_user_id')) {
                $model->assigned_user_name = $model->assigned_user_id ? $model->assignedUser->name : null;
            }
        });
        self::saved(function ($model) {
            if ($model->isDirty('assigned_user_id') && $model->assigned_user_id) {
                $validatedData = [
                    'company_asset_id' => $model->id,
                    'assigned_user_id' => $model->assigned_user_id,
                    'assigned_user_name' => $model->assigned_user_name,
                    'assigned_at' => now(),
                    'returned_at' => null,
                    'status_kondisi' => $model->status_kondisi,
                    'status_barang' => $model->status_barang,
                ];

                CompanyAssetHistoryRepository::create($validatedData);
            }
        });
    }

    const STATUS_KONDISI_SANGAT_BAIK = 'Sangat Baik';
    const STATUS_KONDISI_BAIK = 'Baik';
    const STATUS_KONDISI_RUSAK_RINGAN = 'Rusak Ringan';
    const STATUS_KONDISI_RUSAK_BERAT = 'Rusak Berat';
    const STATUS_KONDISI_DALAM_PERBAIKAN = 'Dalam Perbaikan';
    const STATUS_KONDISI_RUSAK_TOTAL = 'Rusak Total';
    const STATUS_KONDISI_DIHAPUSKAN = 'Dihapuskan';

    const STATUS_KONDISI_CHOICE = [
        self::STATUS_KONDISI_SANGAT_BAIK => 'Sangat Baik',
        self::STATUS_KONDISI_BAIK => 'Baik',
        self::STATUS_KONDISI_RUSAK_RINGAN => 'Rusak Ringan',
        self::STATUS_KONDISI_RUSAK_BERAT => 'Rusak Berat',
        self::STATUS_KONDISI_DALAM_PERBAIKAN => 'Dalam Perbaikan',
        self::STATUS_KONDISI_RUSAK_TOTAL => 'Rusak Total',
        self::STATUS_KONDISI_DIHAPUSKAN => 'Dihapuskan',
    ];
    const STATUS_PEMBELIAN_BARU = 'Baru';
    const STATUS_PEMBELIAN_SECOND = 'Second';

    const STATUS_PEMBELIAN_CHOICE = [
        self::STATUS_PEMBELIAN_BARU => 'Baru',
        self::STATUS_PEMBELIAN_SECOND => 'Second',
    ];

    const JENIS_LAPTOP = 'Laptop';
    const JENIS_HANDPHONE = 'Handphone';

    const JENIS_CHOICE = [
        self::JENIS_LAPTOP => 'Laptop',
        self::JENIS_HANDPHONE => 'Handphone',
    ];


    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id');
    }

    public function companyAssetHistories()
    {
        return $this->hasMany(CompanyAssetHistory::class, 'company_asset_id', 'id')->orderBy('assigned_at', 'DESC');
    }
}
