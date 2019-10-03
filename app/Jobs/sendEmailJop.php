<?php

namespace App\Jobs;

use App\Mail\notificationMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class sendEmailJop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where('numbersOfPosts','!=',0)->get();
        User::where('numbersOfPosts','!=',0)->update(['numbersOfPosts'=>0]);
        foreach ($users as $user) {
            Mail::to($user->email)->send(new notificationMail($user->name));
        }
    }
}
