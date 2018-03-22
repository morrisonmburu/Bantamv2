<?php

namespace App\Notifications;

use App\EmployeeLeaveApplication;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveApprovalRequestSent extends Notification implements ShouldQueue
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

        $this->message = "Your leave (Ref: ".$data->Application_Code.")application has been sent.";
        $this->title = "Leave Application Sent";
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
            "message"=> $this->title,
            "type" =>"success",
            "details" => $this->data->toArray(),
            "model" => (new \ReflectionClass(EmployeeLeaveApplication::class))->getShortName(),
        ];
    }
}
