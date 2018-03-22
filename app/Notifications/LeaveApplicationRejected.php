<?php

namespace App\Notifications;

use App\Employee;
use App\EmployeeLeaveApplication;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveApplicationRejected extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $data;

    private $message;
    private $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, EmployeeLeaveApplication $data)
    {
        $this->user = $user;
        $this->data = $data;
        $this->message = "Unfortunately, your leave application (Ref:".$data->Application_Code.") was rejected.";
        $this->title = "Leave Application Rejected";

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting("Dear ".$this->user->name)
            ->subject($this->title)
            ->error()
            ->line($this->message);
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
            "message"=> $this->title,
            "type" =>"danger",
            "details" => $this->data->$this->toArray(),
            "model" => (new \ReflectionClass(EmployeeLeaveApplication::class))->getShortName(),
        ];
    }
}
