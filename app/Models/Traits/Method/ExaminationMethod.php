<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/17/2018
 * Time: 8:30 PM
 */

namespace App\Models\Traits\Method;


use App\Models\Auth\User;

trait ExaminationMethod
{
    /*
     * @return bool
     */
    public function isActived()
    {
        return (bool)$this->is_actived;
    }

    public function isReadyToPublish() {
        $check = true;
        if(empty($this->format_test) || empty($this->test_num) || !$this->isActived()) {
            return $check = false;
        }
        if($this->students->count() <= 0)
            return $check = false;
        if($this->proctors->count() <= 0)
            return $check = false;
        if($this->tests->count() != $this->test_num)
            return $check = false;
        return $check;
    }

    public function isFormatTest() {
        return !empty($this->format_test);
    }

    public function getStudentTest($student) {
        $all_tests = $this->tests;
        $test_of_student = null;
        foreach ($all_tests as $test) {
            $students_id_arr = $test->students->pluck('id')->toArray();
            if(in_array($student->id, $students_id_arr))
                $test_of_student = $test;
        }
        return $test_of_student;
    }
}