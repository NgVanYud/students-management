<?php

namespace App\Http\Controllers\Frontend\Student;

use App\Exceptions\GeneralException;
use App\Models\Answer;
use App\Models\Auth\User;
use App\Models\Examination;
use App\Models\Result;
use App\Models\Test;
use App\Repositories\Backend\ExaminationRepository;
use App\Repositories\Backend\QuestionRepository;
use App\Repositories\Backend\TestRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    protected $examinationRepository;
    protected $questionRepository;
    protected $testRepository;

    public function __construct(
        ExaminationRepository $examinationRepository,
        QuestionRepository $questionRepository,
        TestRepository $testRepository
    )
    {
        $this->examinationRepository = $examinationRepository;
        $this->questionRepository = $questionRepository;
        $this->testRepository = $testRepository;
    }


    public function joinTest(Request $request, User $user, Examination $examination) {
        $test = $examination->getStudentTest($user);
        if(!$this->testRepository->isValidToJoinTest($test, $user)) {
            throw new GeneralException('You do not have permission or you have finished this test.');
        }

        $result = $test->students()->where('student_id', $user->id)->first()->result;
        $read_at = $result->read_at;
        $timeout = null;
        $timeout_second = null;
        if(is_null($read_at)) {
            \DB::transaction(function() use (&$examination, &$test, &$user, &$result, &$timeout, &$timeout_second) {
                $read_at = Carbon::now();
                $timeout = $examination->timeout;
                $timeout_second = $timeout * 60;
                $status = Result::STATUS_CODES['doing'];

                $test->students()->sync([
                    ($user->id)=>[
                        'read_at' => $read_at,
                        'timeout' => $timeout,
                        'status'  => $status
                    ]
                ]);
            });
        } else {
            /**
             * Time từ khi read -> now
             */
            $time_left = Carbon::parse($read_at)->diffInRealSeconds(Carbon::now());
            $timeout = $examination->timeout;

            if($time_left >= $timeout*60) {
                $timeout_second = 0;
                $timeout = 0;
                \DB::transaction(function() use (&$examination, &$test, &$user, &$result, &$timeout, &$timeout_second) {
                    $status = Result::STATUS_CODES['doing'];
                    $test->students()->sync([
                        ($user->id)=>[
                            'timeout' => $timeout,
                            'status'  => $status
                        ]
                    ]);
                });

            } else {
                $timeout_second = $timeout*60 - $time_left;
                $timeout = intval(floor($timeout_second/60));

                \DB::transaction(function() use (&$examination, &$test, &$user, &$result, &$timeout, &$timeout_second) {
                    $status = Result::STATUS_CODES['doing'];
                    $test->students()->sync([
                        ($user->id)=>[
                            'timeout' => $timeout,
                            'status'  => $status,
                        ]
                    ]);
                });
            }
        }

        return view('frontend.exam.test', [
            'examination' => $examination,
            'test' => $test,
            'timeout' => $timeout_second
        ]);
    }


    public function submitTest(Request $request, User $user, Examination $examination) {
        $questions = $request->questions;
        $answers = $request->answers;
        $result = $this->getResult($questions, $answers);
        try {
            \DB::transaction(function() use (&$examination, &$user, &$result) {
                $test = $examination->getStudentTest($user);
                $status = Result::STATUS_CODES['done'];
                $test->students()->sync([
                    ($user->id)=>[
                        'timeout' => 0,
                        'status'  => $status,
                        'correct_ans' => $result,
                        'is_completed' => Test::COMPLETED_CODE
                    ]
                ]);
            });
            return redirect()->route('frontend.user.dashboard')->withFlashSuccess(
                'Congratulations!!! You have just your test with score '.$result.'/'.$examination->question_num
            );
        } catch (\Exception $ex) {
            throw new GeneralException($ex->getMessage());
        }
    }

    public function getResult($questions, $answers) {
        $result = 0;
        foreach ($questions as $key => $question_id) {
            $correct_ans_id = $this->questionRepository->getAllCorrectOptions(intval($question_id));
            sort($correct_ans_id);
            if (isset($answers[$question_id])) {
                $temp_ans = $answers[$question_id];
                $temp_ans = array_map('intval',$temp_ans);
                sort($temp_ans);
                if($temp_ans == $correct_ans_id)
                $result += 1;
            }
        }
        return $result;
    }
}
