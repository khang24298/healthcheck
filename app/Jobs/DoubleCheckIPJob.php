<?php

namespace App\Jobs;

use App\Http\Controllers\IPController;
use App\Http\Controllers\Model\IPAddress;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class DoubleCheckIPJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $ip;
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
        //Create instance of IPController
        $ctrl = new IPController();
        
        // Handle if IP is alive or not
        if($ctrl->isAliveIP($this->ip) === true){
            $this->ip->status = true;
        }
        else{
            dispatch($this);
        }

        //Get execution time
        $cur = exec('date +"%d/%m/%y, %T"');

        //Update value for ip
        $this->ip->attempts += 1;
        ($this->ip->attempts == 0) ? $this->ip->first_check = $cur : '';
        $this->ip->final_check = $cur;
        $this->ip->save();
    }
}
