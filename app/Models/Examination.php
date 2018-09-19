<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Traits\Attribute\ExaminationAttribute;
use App\Models\Traits\Method\ExaminationMethod;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use SoftDeletes,
        Uuid,
        ExaminationAttribute,
        ExaminationMethod;

    const ACTIVE_CODE = 1;
    const INACTIVE_CODE = 0;

    const TAB_TYPES = [
        'general_info'      => 'general info',
        'proctors'          => 'proctors',
        'students'          => 'students',
    ];

    protected $fillable = [
        'begin_time',
        'subject_id',
        'is_actived',
        'code',
        'uuid',
        'note',
        'name',
        'format_test',
        'question_num',
        'timeout',
        'is_published',
        'test_num'
    ];

    protected $casts = [
        'format_test' => 'array'
    ];

    //dinh dang so cau hoi trong từng chapter
    protected $appends = [
        'formatTest'
    ];

    protected $table = 'examinations';

    protected $dates = ['begin_time', 'deleted_at'];

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function students() {
        return $this->belongsToMany(User::class,
            'examination_student',
            'examination_id',
            'student_id'
        );
    }

    public function proctors() {
        return $this->belongsToMany(User::class,
            'examination_proctor',
            'examination_id',
            'proctor_id'
        );
    }

    public function tests() {
        return $this->hasMany(
            Test::class,
            'examination_id',
            'id'
        );
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function setBeginTime($date, $time) {
        $this->begin_time = strtotime("$date $time");
        return $this->begin_time;
    }

    public function getBeginTimeString($date, $time) {
        return $this->setBeginTime($date, $time)->toDateTimeString();
    }

    public function scopePublished($query, $status = true)
    {
        return $query->where('is_published', intval($status));
    }
}
