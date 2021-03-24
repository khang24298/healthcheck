<?php

namespace App\Jobs;
use App\Http\Controllers\Model\IPAddress;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\IPController;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;


class CheckHealthJob extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $ip;
    protected $tries = 3;
    protected $timeout = 10;
    public function __construct(IPAddress $ip)
    {
       $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info($this->ip);
        $ip = $this->ip;
        $ctrl = new IPController();
        if($ctrl->isAliveIP($ip) == true){
            $ip->status = true;
        }
        else{
            // dispatch(new DoubleCheckIPJob($this->ip));
        }
        //Get execution time
        $cur = exec('date +"%d/%m/%y, %T"');

        //Update value for ip
        ($ip->attempts == 0) ? $ip->first_check = $cur : '';
        $ip->attempts += 1;
        $ip->final_check = $cur;
        $ip->save();
    }
}
