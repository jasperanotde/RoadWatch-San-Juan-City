<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AssignedReport extends Notification
{
    use Queueable; 

    /**
     * Create a new notification instance.
     */
    protected $message;
    protected $notifURL;
    protected $reportName;
    protected $userName;
    protected $currentUserAuth;
    protected $assignedUser;

    public function __construct($assignedUser, $currentUserAuth, $userName, $reportName, $notifURL,$message)
    {
        $this->message = $message;
        $this->notifURL = $notifURL;
        $this->reportName = $reportName;
        $this->userName = $userName;
        $this->currentUserAuth = $currentUserAuth;
        $this->assignedUser = $assignedUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($notifiable == $this->currentUserAuth) {
            $message = 'You have successfully approved and assigned the report \'' . $this->reportName . '\' to ' . $this->userName;
        } 
        if ($notifiable == $this->assignedUser) {
            $message = 'Hi, ' . $this->userName . ', a new report \'' . $this->reportName . '\' was Assigned to you.';
        }
    
        return (new MailMessage)
            ->greeting('Report Assigned')
            ->line($message)
            ->action('View Report', $this->notifURL)
            ->line('Check the link to investigate.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {

        // Create a new Carbon instance
        $carbon = new Carbon();

        // Set the timezone to 'Asia/Manila'
        $carbon->setTimezone('Asia/Manila');

        // Get the current time in the Philippines timezone and format it
        $formattedDate = $carbon->format('F j, Y \a\t h:i A');

        return [
            'data' => $this->message,
            'date' => $formattedDate,
            'notifURL' => $this->notifURL,
        ];
    }
}
