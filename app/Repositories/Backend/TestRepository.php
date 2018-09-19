<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/18/2018
 * Time: 8:22 PM
 */

namespace App\Repositories\Backend;


use App\Models\Test;
use App\Repositories\BaseRepository;

class TestRepository extends BaseRepository
{
    public function model()
    {
        return Test::class;
    }

}