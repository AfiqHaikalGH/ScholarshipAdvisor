<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password
                            {email : The email of the user}
                            {password : The new password to set}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[TEMPORARY] Reset a user password by email. Delete this command after use.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email    = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("No user found with email: {$email}");
            return Command::FAILURE;
        }

        // Show user details and ask for confirmation
        $this->info("Found user: {$user->name} ({$user->email}) | Role: {$user->role}");

        if (! $this->confirm("Are you sure you want to reset the password for this account?")) {
            $this->warn('Operation cancelled.');
            return Command::SUCCESS;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("✅ Password successfully reset for {$email}.");
        $this->warn('⚠️  IMPORTANT: Delete this command file (ResetAdminPassword.php) after use for security!');

        return Command::SUCCESS;
    }
}
