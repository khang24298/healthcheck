<?php

namespace App\Jobs;


use App\Http\Controllers\Model\IPAddress;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
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
        $this->doubleCheckIP($this->ip);
    }

    // If failed_job
    public function failed(Throwable $exception)
    {
        //Get execution time
        $cur = shell_exec('date +"%d/%m/%y, %T"');
        //Update value for ip
        ($this->ip->attempts == 0) ? $this->ip->first_check = $cur : '';
        $this->ip->attempts += 1;
        $this->ip->final_check = $cur;
        $this->ip->isChecking = false;
        $this->ip->save();
    }
    // Double Check IP
    public function doubleCheckIP(IPAddress $ip){
        if($this->isAliveIP($ip) == true){
            $ip->status = true;
        }
        //Get execution time
        $cur = shell_exec('date +"%d/%m/%y, %T"');
   
        //Update value for ip
        ($ip->attempts == 0) ? $ip->first_check = $cur : '';
        $ip->attempts += 1;
        $ip->final_check = $cur;
        $ip->isChecking = false;
        $ip->save();
    }

    //Check if IP alive or not 
    public function isAliveIP(IPAddress $ip){
        if($ip->port){ 
            
            try{
                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                $result = socket_connect($socket, $ip->ip, $ip->port);
            }
            catch(Exception $e){
                Log::info($e->getMessage());
                $result = false;
            }
        }
        else{
            try{
                $output = shell_exec("ping -c 1 -W 1 ".$ip->ip);
                $re = explode("\n",$output);
                if(count($re) == 7){
                    $result = true;
                }
                else{
                    $result = false;
                }
            }
            catch(Exception $e){
                $result = false;
                Log::info($e->getMessage());
            }
        }
        return $result;
    }
}
