<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class EmployeeHobby extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'user_id',
        'nama_hobi',
    ];

    protected $guarded = ['id'];
    protected $table = "employee_hobies";
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
