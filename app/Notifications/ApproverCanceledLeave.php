<?php
namespace App\Notifications;
use App\ApprovalEntry;
use App\EmployeeApprover;
use App\EmployeeLeaveApplication;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApproverCanceledLeave extends Notification implements  ShouldQueue
{
    use Queueable;
    protected $approver;
    protected $entry;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $approver,ApprovalEntry $leaveRec)
    {
        $this->approver=$approver;
        $this->entry=$leaveRec;
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
            ->subject('Leave Canceled')
            ->line('This is to notify you that leave code '.$this->entry->Document_No." has been canceled")
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
            "message"=>"Leave code ".$this->entry->Document_No." canceled.",
            "type" =>"danger"
        ];
    }
}
