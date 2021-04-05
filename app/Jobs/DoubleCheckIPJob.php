<?php

namespace App\Jobs;


use App\Http\Controllers\Model\IPAddress;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;
class DoubleCheckIPJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $ip;
    public function __construct(IPAddress $ip)
    {
        $this->ip = $ip;
        $this->ip->isChecking = true;
        $this->ip->save();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->doubleCheckIP();
        return;
    }

    // If failed_job
    public function failed()
    {
        //Get execution time
        $cur = shell_exec('date +"%Y-%m-%d %T"');
        //Update value for ip
        // ($this->ip->attempts == 0) ? $this->ip->first_check = $cur : '';
        $this->ip->attempts += 1;
        $this->ip->final_check = $cur;
        $this->ip->isChecking = false;
        $this->ip->save();
        dispatch($this);
        return;
    }
    // Double Check IP
    public function doubleCheckIP(){
        if($this->isAliveIP($this->ip) == true){
            $this->ip->status = true;
        }
        else{
            $this->failed();
        }
        //Get execution time
        $cur = shell_exec('date +"%Y-%m-%d %T"');
   
        //Update value for ip
        // ($this->ip->attempts == 0) ? $this->ip->first_check = $cur : '';
        $this->ip->attempts += 1;
        $this->ip->final_check = $cur;
        $this->ip->isChecking = false;
        $this->ip->save();
    }

    //Check if IP alive or not 
    public function isAliveIP(){
        if($this->ip->port){ 
            
            try{
                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                $result = socket_connect($socket, $this->ip->ip, $this->ip->port);
            }
            catch(Exception $e){
                Log::info($e->getMessage());
                $result = false;
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
                        break;
                    }
                }
                $result = false;
            }
            catch(Exception $e){
                $result = false;
                Log::info($e->getMessage());
            }
        }
        return $result;
    }
}
