<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/23/2018
 * Time: 8:32 PM
 */

namespace App\Document\Word;


use App\Exceptions\GeneralException;
use App\Models\Examination;
use App\Models\Test;
use App\Models\Auth\User;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class ResultTest
{
    protected $student;
    protected $examination;
    protected $test;

    public function __construct(User $student, Examination $examination, Test $test)
    {
        $this->student = $student;
        $this->examination = $examination;
        $this->test = $test;
    }


    public function storeWord() {
        $template = new TemplateProcessor(storage_path('app/public/file/results/template_result.docx'));
        /**
         * Lấy điểm của student
         */
        $score = $this->test->students->find($this->student->id)->result->correct_ans;
        $template->setValue('exam', $this->examination->name);
        $template->setValue('subject', $this->examination->subject->name);
        $template->setValue('student', ucwords($this->student->name));
        $template->setValue('student_code', $this->student->code);
        $template->setValue('test_code', $this->test->code);
        $template->setValue('test_date', $this->examination->begin_time->format("d-m-Y"));
        $template->setValue('score', $score.'/'.$this->test->num_questions);
        $now = Carbon::now();
        $template->setValue('date', $now->day);
        $template->setValue('month', $now->month);
        $template->setValue('year', $now->year);

        try{
            $template->saveAs(storage_path('app\public\file\results\test_result.docx'));
        }catch (Exception $e){
            throw new GeneralException($e->getMessage());
        }
        $file_path = storage_path('app\public\file\results\test_result.docx');
        return $file_path;
//        return response()->download(storage_path('app\public\file\results\test_result.docx', 'result.docx', $headers));
//        return Storage::disk('local')->download('public/file/results/test_result.docx', );
    }
}