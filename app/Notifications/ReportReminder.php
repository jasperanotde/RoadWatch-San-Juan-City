<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Report;
use Carbon\Carbon;

class ReportReminder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $report;
    protected $assingedUser;

    public function __construct($report, $assignedUser)
    {
        $this->report = $report;
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
        $targetDate = Carbon::parse($this->report->targetDate, 'Asia/Manila');
        $reportURL = url(route('reports.show', ['report' => $this->report->id]));

        return (new MailMessage)
                ->greeting('Hi ' . $this->assignedUser->name . ',')
                ->line('This is to inform you that report \'' . $this->report->name . '\' assigned to you will be due on ' . $targetDate->format('F d, Y (l)'))
                ->action('View Report', $reportURL)
                ->line('Please do necessary actions to complete the report. Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {

        $carbon = new Carbon();
        $carbon->setTimezone('Asia/Manila');
        $formattedDate = $carbon->format('F j, Y \a\t h:i A');
        $targetDate = Carbon::parse($this->report->targetDate, 'Asia/Manila');
        $reportURL = url(route('reports.show', ['report' => $this->report->id]));
        $message = 'Report \'' . $this->report->name . '\' assigned to you will be due on ' . $targetDate->format('F d, Y (l)');

        return [
            'data' => $message,
            'date' => $formattedDate,
            'notifURL' => $reportURL,
        ];
    }
}
