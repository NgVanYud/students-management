<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/13/2018
 * Time: 2:45 PM
 */

namespace App\Models\Traits\Method;


trait QuestionMethod
{
    public function isActived()
    {
        return (bool)$this->is_actived;
    }
}