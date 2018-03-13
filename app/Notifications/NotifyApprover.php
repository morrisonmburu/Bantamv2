<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\EmployeeApprover;
class NotifyApprover extends Notification implements ShouldQueue
{
    use Queueable;
    public function __construct()
    {
        //
    }
    public function via($notifiable)
    {
        return ['database','mail'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello?')
                    ->line('You have a new approval request. Login to view details.')
                    ->subject("New leave approval request")
                    ->action('CLick to login', url('/')) // Approval URL
                    ->line('Thank you.');
    }
    public function toArray($notifiable)
    {
        return [
            "message"=>"You have a new leave application request"
        ];
    }
}
