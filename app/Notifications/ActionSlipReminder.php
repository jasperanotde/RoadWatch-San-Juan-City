<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Report;
use Carbon\Carbon;

class ActionSlipReminder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $report;
    protected $submission;
    protected $assignedUser;

    public function __construct($report, $submission, $assignedUser)
    {
        $this->report = $report;
        $this->submission = $submission;
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
        $startDate = Carbon::parse($this->submission->startDate, 'Asia/Manila');
        $targetDate = Carbon::parse($this->submission->targetDate, 'Asia/Manila');
        $reportURL = url(route('reports.show', ['report' => $this->report->id]));

        return (new MailMessage)
                ->greeting('Hi ' . $this->assignedUser->name . ',')
                ->line('A new action slip was created for \'' . $this->report->name . '\' assigned to you.')
                ->line('Start date: ' . $startDate->format('F d, Y (l)'))
                ->line('End date: ' . $targetDate->format('F d, Y (l)'))
                ->action('View Report', $reportURL)
                ->line('Please do necessary actions to complete the Action Slip. Thank you!');
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
        $reportURL = url(route('reports.show', ['report' => $this->report->id]));
        $message = 'New Action Slip created for report \'' . $this->report->name . '\' assigned to you.';

        return [
            'data' => $message,
            'date' => $formattedDate,
            'notifURL' => $reportURL,
        ];
    }
}
