<?php

namespace App\Jobs;

use App\Http\Controllers\Model\IPAddress;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Jobs\DoubleCheckIPJob;

class CheckHealthJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $ip;
    public $deleteWhenMissingModels = true;
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
        $this->ip->isChecking = true;
        $this->ip->save();
        $this->firstCheckIP();
    }

    // If failed jobs
    public function failed($e)
    {
        //Get execution time
        $cur = now();
        //Update value for ip
        ($this->ip->total_attempts == 0) ? $this->ip->first_check = $cur : '';
        $this->ip->total_attempts += 1;
        $this->ip->final_die_time = $cur;
        $this->ip->isChecking = false;
        $this->ip->current_status = false;
        $this->ip->save();
        $job = (new DoubleCheckIPJob($this->ip))->onQueue('double');
        dispatch($job);
        Log::error($e->getMessage());
    }

    
    // FirstCheck function
    public function firstCheckIP(){
        //Get execution time
        $cur = now();
        if($this->isAliveIP() == true){
            $this->ip->current_status = true;
            $this->ip->final_alive_time = $cur;
            $this->ip->alive_times += 1;
            ($this->ip->total_attempts == 0) ? $this->ip->first_check = $cur : '';
            $this->ip->total_attempts += 1;
            $this->ip->isChecking = false;
            $this->ip->save();
            $job = (new CheckHealthJob($this->ip))->onQueue('first')->delay(300);
            dispatch($job);
        }
        else{
            throw new Exception("Error while checking first check: ",1);
        }
    }

    //Check if IP alive or not 
    public function isAliveIP(){
        $result = false;
        if($this->ip->port){
            try{
                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                $result = socket_connect($socket, $this->ip->ip, $this->ip->port);
            }
            catch(Exception $e){
                Log::info($e->getMessage());
            }
        }
        else{
            try{
                $output = shell_exec("ping -c 8 -W 1 ".$this->ip->ip);
                $outputs = explode("\n",$output);
                $char = "round-trip";
                foreach($outputs as $test){
                    if (strpos($test, $char) !== false) {
                        $result = true;
                    }
                }
            }
            catch(Exception $e){
                Log::info($e->getMessage());
            }
        }
        return $result;
    }
}
