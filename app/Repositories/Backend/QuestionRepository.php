<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/11/2018
 * Time: 11:32 PM
 */

namespace App\Repositories\Backend;


use App\Models\Question;
use App\Models\Traits\Method\QuestionMethod;
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

    public function getIsActivePaginated(
        $is_active = true,
        array $columns = ['*'],
        $paged = 25,
        $orderBy = 'created_at',
        $sort = 'desc'
    ): LengthAwarePaginator
    {
        return $this->model
//            ->with('chapters', 'lecturers')
            ->select($columns)
            ->active($is_active)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function getAllPaginated($paged = 25, $columns = ['*'], $orderBy = 'created_at', $sort = 'asc') {
        return $this->model
            ->select($columns)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function active(Question $question)
    {
        if ($question->isActived()) {
            throw new GeneralException(__('exceptions.backend.questions.already_actived'));
        }
        $question->is_actived = Question::ACTIVE_CODE;
        $actived = $question->save();

        if ($actived) {
            return $question;
        }

        throw new GeneralException(__('exceptions.backend.questions.cant_active'));
    }

    public function inactive(Question $question) {
        if(!$question->isActived()) {
            throw new GeneralException(__('exceptions.backend.questions.not_actived'));
        }
        $question->is_actived = Question::INACTIVE_CODE;
        $inactived = $question->save();
        if($inactived) {
            return $question;
        }
        throw new GeneralException(__('exceptions.backend.questions.cant_inactive'));
    }
}