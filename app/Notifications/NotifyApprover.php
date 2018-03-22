<?php

namespace App\Notifications;

use App\ApprovalEntry;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\EmployeeApprover;
class NotifyApprover extends Notification implements ShouldQueue
{
    use Queueable;

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
    public function __construct(User $user, ApprovalEntry $data)
    {
        $this->user = $user;
        $this->data = $data;

        $this->message = "A new approval request (Ref: ".$this->data->Table_ID.") is awaiting your action.";
        $this->title = "New Approval Request";
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
            "type" =>"info",
            "details" => $this->data->toArray(),
            "model" =>(new \ReflectionClass( ApprovalEntry::class))->getShortName(),
        ];
    }
}
