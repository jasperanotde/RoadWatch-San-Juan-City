<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\ReportReminder;
use App\Models\User;
use App\Models\Report;

class SendTargetEndDateReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-target-end-date-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = now()->addDay();
        $reportsDueTomorrow = Report::whereDate('targetDate', $tomorrow)->get();

        foreach ($reportsDueTomorrow as $report) {
            $assignedUser = User::find($report->assigned_user_id);
            
            $assignedUser->notify(new ReportReminder($report, $assignedUser));
        }

        $this->info('Report reminders sent successfully.');
    }
}
