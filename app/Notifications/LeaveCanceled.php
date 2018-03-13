<?php
namespace App\Notifications;
use App\EmployeeApprover;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveCanceled extends Notification implements  ShouldQueue
{
    use Queueable;
    protected $approver;
    protected $leaveRec;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EmployeeApprover $approver,$leaveRec)
    {
        $this->approver=$approver;
        $this->leaveRec=$leaveRec;
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            "message"=>"Leave code ".$this->leaveRec->Application_Code." has been cancelled."
        ];
    }
}
