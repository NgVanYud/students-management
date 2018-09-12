<?php

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Subject::class, 25)->create()->each(function ($subject) {
            $subject->chapters()->save(factory(\App\Models\Chapter::class, 8)->make()
            ->each(function($chapter) {
                $chapter->questions()->save(factory(\App\Models\Question::class, 20)->make(['subject_id' => $chapter->subject_id])
                ->each(function($question) {
                    $question->answers()->save(factory(\App\Models\Answer::class, config('question.options_num'))->make());
                }));
            }));
        });
    }
}
