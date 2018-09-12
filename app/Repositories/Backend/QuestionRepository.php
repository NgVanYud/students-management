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
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionRepository extends BaseRepository
{
    public function model()
    {
        return Question::class;
    }

    public function getActive(array $columns = ['*'], $orderBy = 'created_at', $sort = 'asc')
    {
        return $this->model
            ->select($columns)
            ->active()
            ->orderBy($orderBy, $sort)
            ->get();
    }

    public function getActivePaginated(
        array $columns = ['*'],
        $paged = 25,
        $orderBy = 'created_at',
        $sort = 'desc'
    ): LengthAwarePaginator
    {
        return $this->model
//            ->with('chapters', 'lecturers')
            ->select($columns)
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }
}