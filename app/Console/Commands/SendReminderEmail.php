<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SendReminderEmail extends Command
{
    protected $signature = 'send:reminder';

    protected $description = 'Send reminder email to users 15 days after account creation';

    public function handle()
    {
        $users = Company::where('created_at', '=', now()->subDays(15))
            ->where('subscription_id', 1)
            ->get();

        // Check if there are any users before attempting to send emails
        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $email = $user->email;

                $data = [
                    'email' => $user->email,
                    'password' => $user->name, // Consider using a more secure method for generating a temporary password
                ];

                $mailContent = view('mail3', $data)->render();

                Mail::send([], [], function ($message) use ($mailContent, $email) {
                    $message->to($email, 'User Login Credentials')
                        ->subject('User Login Credentials')
                        ->setBody($mailContent, 'text/html');
                });

                $this->info('Reminder email sent successfully for user: ' . $user->id);

                if ($user->licences <= 250) {
                    $update = DB::table('company')->where('id', $user->id)->update(['subscription_id' => 4]);
                } elseif ($user->licences <= 500) {
                    $update = DB::table('company')->where('id', $user->id)->update(['subscription_id' => 3]);
                } elseif ($user->licences <= 1000) {
                    $update = DB::table('company')->where('id', $user->id)->update(['subscription_id' => 2]);
                }
            }
        } else {
            $this->info('No users found to send reminder emails.');
        }
    }
}
