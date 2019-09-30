<?php

namespace App\Console\Commands;

use App\Mail\notificationMail;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class sendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users =User::all()->reverse()->take(2);
        foreach ($users as $user){
            Mail::to($user->email)->send(new notificationMail($user->name));
        }
        $this->info('Mails were send successfully');

    }
}
