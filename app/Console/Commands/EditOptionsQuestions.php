<?php

namespace App\Console\Commands;

use App\Repositories\Backend\QuestionRepository;
use Illuminate\Console\Command;

class EditOptionsQuestions extends Command
{
    protected $questionRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'questions:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit options in questions that is invalid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        parent::__construct();
        $this->questionRepository = $questionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '1024M');
        $all_questions = $this->questionRepository->orderBy('created_at', 'desc')->get();
        $all_questions->each(function($question, $key) {
            $all_options = $question->answers;
            $check_arr = $all_options->pluck('is_correct')->toArray();
            /*
             * Đúng toàn bộ
             */
            if(in_array('1', $check_arr) && !in_array('0', $check_arr)) {
                $question->answers()->first()->update(['is_correct' => 0]);
            }
            /*
             * Sai toàn bộ
             */
            else if(in_array('0', $check_arr) && !in_array('1', $check_arr)) {
                $question->answers()->first()->update(['is_correct' => 1]);
            }
        });
        $this->info("Update questions successfull.");
    }
}
