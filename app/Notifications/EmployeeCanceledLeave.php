<?php

namespace App\Notifications;

use App\EmployeeLeaveApplication;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmployeeCanceledLeave extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user;
    protected $data;

    private $message;
    private $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, EmployeeLeaveApplication $leaveRec)
    {
        $this->user= $user;
        $this->data= $leaveRec;


        $this->message = "You application (Ref: ".$leaveRec->Application_Code.") has been canceled.";
        $this->title = "Leave Application Successfully Canceled";
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
            "title" => $this->title,
            "message"=> $this->message,
            "type" =>"success",
            "details" => $this->data->toArray(),
            "model" => (new \ReflectionClass(EmployeeLeaveApplication::class))->getShortName(),
        ];
    }
}
