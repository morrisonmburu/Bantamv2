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
    protected $data;

    private $message;
    private $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $approver,ApprovalEntry $leaveRec)
    {
        $this->approver=$approver;
        $this->data = $leaveRec;

        $this->message = $this->data->employee->First_Name."'s application (Ref: $leaveRec->Document_No) has been canceled.";
        $this->title = "Canceled leave application";
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
            ->greeting("Dear ".$this->approver->name)
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
            "model" => (new \ReflectionClass(ApprovalEntry::class))->getShortName(),
        ];
    }
}
