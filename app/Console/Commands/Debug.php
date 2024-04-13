<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\TrackingStartedNotification;
use Illuminate\Console\Command;

class Debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug';

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
        // Send all the tracking started notifications

        $users = User::all();

        foreach ($users as $user) {
            $user->notifyNow(new TrackingStartedNotification());
        }
    }
}
