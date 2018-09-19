<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/15/2018
 * Time: 11:01 PM
 */

namespace App\Repositories\Backend;


use App\Exceptions\GeneralException;
use App\Models\Examination;
use App\Models\Subject;
use App\Repositories\BaseRepository;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

class ExaminationRepository extends BaseRepository
{
    public function model()
    {
        return Examination::class;
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->with('roles', 'permissions', 'providers')
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function active(Examination $examination)
    {
        if ($examination->isActived()) {
            throw new GeneralException(__('exceptions.backend.examinations.already_actived'));
        }
        $examination->is_actived = Examination::ACTIVE_CODE;
        $actived = $examination->save();

        if ($actived) {
            return $examination;
        }

        throw new GeneralException(__('exceptions.backend.examinations.cant_active'));
    }

    public function inactive(Examination $examination) {
        if(!$examination->isActived()) {
            throw new GeneralException(__('exceptions.backend.examinations.not_actived'));
        }
        $examination->is_actived = Examination::INACTIVE_CODE;
        $inactived = $examination->save();
        if($inactived) {
            return $examination;
        }
        throw new GeneralException(__('exceptions.backend.examinations.cant_inactive'));
    }

    public function getTopNearlyExamination($prev_terms_num, Subject $subject) {
        $prev_terms = $this->model
            ->where('subject_id', $subject->id)
            ->published()
            ->orderBy('created_at', 'desc')
            ->take($prev_terms_num)
            ->get();
        return $prev_terms;
    }

    public function createMutipleTest(Examination $examination) {
        try {
            \DB::transaction(function() use ($examination){
                $test_num = intval($examination->test_num);
                for($i = 0; $i < $test_num; $i++) {
                    $examination->tests()->save(new Test([
                        'code' => $examination->code.'-'.$examination->subject->abbreviation.'-'.($i+1),
                        'num_questions' => $examination->question_num,
                    ]));
                }
            });
            return $examination;

        } catch (\Exception $ex) {
            throw new GeneralException('This error in create tests for examination');
        }
    }

    public function getQuestionWithChapter(Examination $examinations) {
        $arr_question = [];
        $questions = $examinations->tests->questions;
        foreach ($questions as $question) {
            $arr_question[$question->chapter->slug][] = $question->id;
        }
        return $arr_question;
    }

    public function allocateTests(Examination $examination) {
        $tests = $examination->tests->toArray();
        $tests_num = $examination->test_num;

        $students_shuffled = $examination->students->shuffle();
        $count = 0;

        try {
            foreach ($students_shuffled as $student) {
                $student->tests()->attach($tests[$count%$tests_num]['id']);
                $count+=1;
            }
        } catch (\Exception $ex) {
            throw new GeneralException($ex->getMessage());
        }
    }

    public function delAllTest(Examination $examination) {
        $all_tests = $examination->tests;
        if(!empty($all_tests) && $all_tests->count() > 0) {
            $all_tests->each(function($test, $key) {
                $test->questions()->detach();
                $test->students()->detach();
            });
            $examination->tests()->delete();
        }
        return $examination;
    }
}