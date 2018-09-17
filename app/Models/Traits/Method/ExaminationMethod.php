<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/17/2018
 * Time: 8:30 PM
 */

namespace App\Models\Traits\Method;


trait ExaminationMethod
{
    /*
     * @return bool
     */
    public function isActived()
    {
        return (bool)$this->is_actived;
    }
}