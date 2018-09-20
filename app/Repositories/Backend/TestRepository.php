<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/18/2018
 * Time: 8:22 PM
 */

namespace App\Repositories\Backend;


use App\Models\Result;
use App\Models\Test;
use App\Repositories\BaseRepository;

class TestRepository extends BaseRepository
{
    public function model()
    {
        return Test::class;
    }

    public function isValidToJoinTest($test, $student)
    {
        $check = true;
        $result = $test->students()->where('student_id', $student->id)->first()->result;
        if( !empty($result->is_completed) || !empty($result->timeout) || $result->status == Result::STATUS_CODES['done']) {
            $check = false;
        }
        return $check;
    }

}