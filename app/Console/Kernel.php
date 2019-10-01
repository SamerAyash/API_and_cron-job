<?php

namespace App\Console;

use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $userN;
    protected $commands = [
        'App\Console\Commands\sendEmailCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $users = User::where('numbersOfPosts',1);
         foreach ($users as $user){
             $this->userN =$user;
             $schedule->command('email:send '.$this->userN->id )
                 ->before(function (){
                     $this->userN->numbersOfPosts = 0;
                     $this->userN->update();
                 })
                 ->everyMinute();
         }
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
