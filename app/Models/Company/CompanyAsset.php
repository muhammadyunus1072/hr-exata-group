<?php

namespace App\Models\Company;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class CompanyAsset extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'assigned_user_id',
        'assigned_at',
        'nama_barang',
        'serial_number',
        'divisi',
        'brand',
        'keterangan',
        'status_barang',
        'status_kondisi',
        'status_pembelian',
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

    protected static function onBoot() {}

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


    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id');
    }
}
