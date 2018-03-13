<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class cancelledLeave extends Notification
{
    use Queueable;
    protected $user;
    protected $leaveRec;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $leaveRec)
    {
        //
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
                    ->greeting('Hello?')
                    ->subject('Leave Cancelled')
                    ->line('This is to notify you that leave code '.$this->leaveRec->Application_Code." has been cancelled")
                    ->line('Thank you.');
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
            "message"=>"You have cancelled leave code ".$this->leaveRec->Application_Code
        ];
    }
}
