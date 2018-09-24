<?php

namespace App\Notifications\Backend\Exam;

use App\Models\Auth\User;
use App\Models\Examination;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExamPublish extends Notification implements ShouldQueue
{
    use Queueable;

    public $examination;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Examination $examination)
    {
        $this->examination = $examination;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail', 'database'];
        return ['database'];

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//        $url = route('frontend.student.join_test', [$notifiable, $this->examination]);
        $url = route('frontend.user.dashboard');
        return (new MailMessage)
                    ->greeting('Hi,'.$notifiable->fullname)
                    ->line('New examination.')
                    ->line('Subject: '.$this->examination->subject->name)
                    ->line('Click button to finish your test')
                    ->action('Access Test', $url);
    }

    public function toDatabase($notifiable) {
        $subject = 'New examination: '.$this->examination->subject->name;
        $content = 'Exam '.$this->examination->name .
            ' last '.$this->examination->timeout . 'minutes'.
            ' with '. $this->examination->question_num. ' questions.';
        return [
            'examination_id' => $this->examination->id,
            'student_id' => $notifiable->id,
            'subject' => $subject,
            'content' => $content
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
