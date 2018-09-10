<?php

namespace App\Models\Auth\Traits\Relationship;

use App\Models\Subject;
use App\Models\System\Session;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\PasswordHistory;

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
}
