<?php

use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\Models\Subject::class, 25)->create()->each(function ($subject) {
//            $subject->chapters()->save(factory(\App\Models\Chapter::class, 10)->make()
//            ->each(function($chapter) {
//                $chapter->questions()->save(factory(\App\Models\Question::class, 20)->make(['subject_id' => $chapter->subject_id])
//                ->each(function($question) {
//                    $question->answers()->save(factory(\App\Models\Answer::class, (int)config('question.options_num'))->make());
//                }));
//            }));
//        });

        factory(\App\Models\Subject::class, 15)->create()
            ->each(function($subject) {
                $subject->chapters()->saveMany(factory(\App\Models\Chapter::class, 15)
                    ->create(['subject_id' => $subject->id])
                    ->each(function($chapter) {
                        $chapter->questions()->saveMany(factory(\App\Models\Question::class, 200)
                        ->create(['subject_id' => $chapter->subject_id, 'chapter_id' => $chapter->id])
                        ->each(function ($question) {
                            $question->answers()->saveMany(factory(\App\Models\Answer::class, (int)config('question.options_num'))
                            ->create(['question_id' => $question->id]));
                }));
            }));
        });

    }
}
