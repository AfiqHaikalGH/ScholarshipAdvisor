<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create
                            {name : Full name of the admin}
                            {email : Email address of the admin}
                            {password : Password for the admin account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[TEMPORARY] Create a new admin user account. Delete this command after use.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name     = $this->argument('name');
        $email    = $this->argument('email');
        $password = $this->argument('password');

        // Validate inputs
        $validator = Validator::make(
            ['email' => $email, 'password' => $password],
            ['email' => 'required|email', 'password' => 'required|min:8']
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return Command::FAILURE;
        }

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            $this->error("A user with email '{$email}' already exists.");
            $this->warn("Tip: Use 'php artisan admin:reset-password {$email} <newpassword>' to reset their password instead.");
            return Command::FAILURE;
        }

        // Show summary and confirm
        $this->info('About to create the following admin account:');
        $this->table(['Field', 'Value'], [
            ['Name',  $name],
            ['Email', $email],
            ['Role',  'admin'],
        ]);

        if (! $this->confirm('Confirm creation of this admin account?')) {
            $this->warn('Operation cancelled.');
            return Command::SUCCESS;
        }

        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password),
            'role'     => 'admin',
        ]);

        $this->info("✅ Admin account created successfully! (ID: {$user->id})");
        $this->warn('⚠️  IMPORTANT: Delete this command file (CreateAdminUser.php) after use for security!');

        return Command::SUCCESS;
    }
}
