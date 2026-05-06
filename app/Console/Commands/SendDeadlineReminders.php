<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-deadline-reminders')]
#[Description('Send reminders for scholarship deadlines to users who have not uploaded proof')]
class SendDeadlineReminders extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = now()->addDays(3)->toDateString();

        $applications = \App\Models\Application::where('status', 'Not Apply')->get();

        $count = 0;
        foreach ($applications as $application) {
            $scholarship = \App\Models\Scholarship::where('name', $application->scholarship_name)->first();

            if ($scholarship && $scholarship->application_end_date) {
                $deadlineDate = \Carbon\Carbon::parse($scholarship->application_end_date)->toDateString();

                if ($deadlineDate === $targetDate) {
                    $application->user->notify(new \App\Notifications\DeadlineReminder($application, $scholarship->name, $scholarship->application_end_date));
                    $count++;
                }
            }
        }

        $this->info("Sent {$count} deadline reminder(s).");
    }
}
