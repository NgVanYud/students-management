<?php

namespace App\Listeners\Backend\Exam;

use App\Events\Backend\Exam\ExamPublished;
use App\Notifications\Backend\Exam\ExamPublish;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class ExamPublishedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ExamPublished $event)
    {
        $all_students = $event->examination->students;
        Notification::send($all_students, new ExamPublish($event->examination));
    }
}
