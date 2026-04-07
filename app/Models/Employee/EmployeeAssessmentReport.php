<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class EmployeeAssessmentReport extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'user_id',
        'nama_dokumen',
        'deskripsi',
        'file',
        'type',
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

    const TYPE_DISC = 'DISC';
    const TYPE_IQ = 'IQ';
    const TYPE_LOVE_LANGUAGE = 'LOVE_LANGUAGE';
    const TYPE_MBTI = 'MBTI';

    const TYPE_CHOICE = [
        self::TYPE_DISC => 'DISC',
        self::TYPE_IQ => 'IQ',
        self::TYPE_LOVE_LANGUAGE => 'LOVE LANGUAGE',
        self::TYPE_MBTI => 'MBTI',
    ];
}
