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
use App\Exceptions\GeneralException;

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

    /*
     * $except: an array of question_id
     */
    public function getRandomQuestions($set_questions , $question_num  = 0) {
        try {
            $random_questions = $set_questions->random($question_num);
            return $random_questions;
        } catch (\Exception $ex) {
            throw new GeneralException('Error in get question in chapter');
//            throw new GeneralException($ex->getMessage());
        }
    }

    public function getAllCorrectOptions($question_id) {
        $question = Question::find($question_id);
        $correct_answers = [];
        if($question) {
            $correct_answers = $question->answers()
                ->correct()
                ->get()
                ->pluck('id')
                ->toArray();
        }
        return $correct_answers;
    }

    public function getBySubjects($subjects) {
        $questịons = [];
        foreach ($subjects as $subject) {
            $questịons = $subject->questions;
        }
        return $questịons;
    }

}