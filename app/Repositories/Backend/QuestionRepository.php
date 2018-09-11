<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/11/2018
 * Time: 11:32 PM
 */

namespace App\Repositories\Backend;


use App\Models\Question;
use App\Repositories\BaseRepository;

class QuestionRepository extends BaseRepository
{
    public function model()
    {
        return Question::class;
    }

}