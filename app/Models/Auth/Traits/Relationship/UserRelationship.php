<?php

namespace App\Models\Auth\Traits\Relationship;

use App\Models\Examination;
use App\Models\Subject;
use App\Models\System\Session;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\PasswordHistory;
use App\Models\Test;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return mixed
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function subjects() {
        return $this->belongsToMany(
            Subject::class,
            'lecturers',
            'lecturer_id',
            'subject_id'
        )->withTimestamps();
    }

    public function examinationsStudent() {
        return $this->belongsToMany(
            Examination::class,
            'examination_student',
            'student_id',
            'examination_id'
        );
    }

    public function examinationsProctor() {
        return $this->belongsToMany(
            Examination::class,
            'examination_proctor',
            'proctor_id',
            'examination_id'
        );
    }

    public function tests() {
        return $this->belongsToMany(
            Test::class,
            'results',
            'student_id',
            'test_id'
        )
            ->as('result')
            ->withTimestamps()
            ->withPivot(
                'uuid', 'correct_ans', 'is_completed', 'deleted_at', 'status', 'read_at', 'timeout'
            );
    }
}
