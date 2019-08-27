<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use App\Notifications\DailyNotify;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotifyTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:notify_test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $data = ['message' => 'This is a test!'];

        Notification::route('mail', 'scaix08121@outlook.com')
            ->notify(new DailyNotify());
    }
}
