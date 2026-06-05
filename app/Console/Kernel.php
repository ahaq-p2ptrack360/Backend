<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Tumhari existing command
        $schedule->command('send:reminder')->everyMinute();
        
        // ✅ INVOICE GENERATION COMMAND - Har mahine 1st date ko 1:00 AM
        $schedule->command('invoices:generate-monthly')
                 ->monthlyOn(1, '01:00')
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/invoice-generation.log'));
        
        // ✅ OVERDUE INVOICES CHECK - Har din 12:00 AM
        $schedule->call(function () {
            \Illuminate\Support\Facades\DB::table('invoices')
                ->where('due_date', '<', now())
                ->where('status', 'pending')
                ->update(['status' => 'overdue']);
        })->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}