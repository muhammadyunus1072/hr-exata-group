<?php

namespace App\Models\Employee;

use App\Traits\Models\UppercaseAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class EmployeeEmergencyContact extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory, UppercaseAttributes;

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_telp',
        'hubungan_keluarga',
    ];

    protected array $uppercase = [
        'nama',
        'hubungan_keluarga'
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
}
