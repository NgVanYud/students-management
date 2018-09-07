<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/7/2018
 * Time: 1:32 AM
 */

namespace App\Models\Traits\Method;

trait SubjectMethod {

    /*
     * @return bool
     */
    public function isActived()
    {
        return (bool)$this->is_actived;
    }

}
