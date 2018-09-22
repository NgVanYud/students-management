<?php

namespace App\Models\Auth\Traits\Method;

/**
 * Traits UserMethod.
 */
trait UserMethod
{
    /**
     * @return mixed
     */
    public function canChangeEmail()
    {
        return config('access.users.change_email');
    }

    /**
     * @return bool
     */
    public function canChangePassword()
    {
        return ! app('session')->has(config('access.socialite_session_name'));
    }

    /**
     * @param bool $size
     *
     * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function getPicture($size = false)
    {
        switch ($this->avatar_type) {
            case 'gravatar':
                if (! $size) {
                    $size = config('gravatar.default.size');
                }

                return gravatar()->get($this->email, ['size' => $size]);

            case 'storage':
                return url('storage/'.$this->avatar_location);
        }

        $social_avatar = $this->providers()->where('provider', $this->avatar_type)->first();
        if ($social_avatar && strlen($social_avatar->avatar)) {
            return $social_avatar->avatar;
        }

        return false;
    }

    /**
     * @param $provider
     *
     * @return bool
     */
    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->hasRole(config('access.users.admin_role')) &&
            $this->isQuizMaker()&&
            $this->isProctor()&&
            $this->isCurator()&&
            $this->isTeacher()&&
            $this->isStudent()&&
            $this->isDefaultUser();
    }

    public function isProctor() {
        return $this->hasAllRoles(
            config('access.users.proctor_role').'|'.
            config('access.users.teacher_role')
        );
    }

    public function isProctorForExamination($examination) {
        $check = false;
        if($this->isAdmin()) {
            $check = true;
        } else if($this->isProctor()) {
            $check = $this->examinationsProctor->contains($examination->id);
        }
        return $check;
    }

    public function isCurator() {
        return $this->hasAllRoles(
            config('access.users.curator_role').'|'.
            config('access.users.teacher_role')
        );
    }

    public function isQuizMaker() {
        return $this->hasAllRoles(config('access.users.quiz_maker_role').'|'.
            config('access.users.teacher_role'));
    }

    public function isValidQuizMaker($subject) {
        $check = false;
        if($this->isAdmin()) {
            $check = true;
        } else if($this->isQuizMaker()) {
            $exists_subject = $this->subjects->contains($subject->id);
            if($exists_subject) $check = true;
        }
        return $check;
    }

    public function isTeacher() {
        return $this->hasRole(config('access.users.teacher_role'));
    }

    public function isTeacherForSubject($subject) {
        $check = false;
        if($this->isAdmin()) {
            $check = true;
        } else if($this->isTeacher()) {
            $exists_subject = $this->subjects->contains($subject->id);
            if($exists_subject) $check = true;
        }
        return $check;
    }

    public function isStudent() {
        return $this->hasRole(config('access.users.student_role'));
    }

    public function isDefaultUser() {
        return $this->hasRole(config('access.users.default_role'));
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return config('access.users.requires_approval') && ! $this->confirmed;
    }


}
