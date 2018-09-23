<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/18/2018
 * Time: 8:26 PM
 */

namespace App\Models\Traits\Attribute;


trait TestAttribute
{
    public function getPrintResultButtonAttribute() {
        return '<a href="' . route('admin.examination.print_result', [$this ]) .
            '" class="btn btn-primary"><i class="fas fa-id-card" data-toggle="tooltip" data-placement="top" title="Print Result"></i></a>';

    }
}