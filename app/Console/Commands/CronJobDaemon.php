<?php

namespace App\Console\Commands;

use App\ModOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronJobDaemon extends Command
{
    /**
     * The interval (in seconds) the scheduler is run daemon mode.
     *
     * @var int
     */
    const SCHEDULE_INTERVAL = 60;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:daemon {--delay= : Number of seconds to delay command} {--interval= : Number of seconds to stop command}';

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
        $start = time();
        $interval = $this->option( 'interval' ) ? intval( $this->option( 'interval' ) ) : self::SCHEDULE_INTERVAL;

        while (1) {
            //
            if ($this->option( 'delay' )) {
                sleep( intval( $this->option( 'delay' ) ) );
            }
            Log::debug('CronJob message', array('context' => 'Run Success!'));

            $sleepTime = max( 0, $interval - ( time() - $start ) );
            if (0 == $sleepTime) {
                Log::debug('CronJob message', array('context' => 'Expire!'));
                break;
            }
        }
    }
}
