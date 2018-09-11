<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/11/2018
 * Time: 11:50 PM
 */

namespace App\Repositories\Backend;


use App\Models\Answer;
use App\Repositories\BaseRepository;

class AnswerRepository extends BaseRepository
{
    public function model()
    {
        return Answer::class;
    }

}