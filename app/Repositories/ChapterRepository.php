<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/8/2018
 * Time: 2:46 AM
 */

namespace App\Repositories;


use App\Models\Chapter;

class ChapterRepository extends BaseRepository
{
    public function model()
    {
        return Chapter::class;
    }

}