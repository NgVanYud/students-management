<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/8/2018
 * Time: 10:59 PM
 */

namespace App\Models\Traits\Method;


trait ChapterMethod
{
    public function isActived() {
        return ($this->is_actived);
    }
}