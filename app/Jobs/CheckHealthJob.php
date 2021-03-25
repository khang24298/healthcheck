<?php

namespace App\Jobs;


use App\Http\Controllers\Model\IPAddress;
use Exception;
use Illuminate\Support\Facades\Log;
class CheckHealthJob extends Job
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

    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->firstCheckIP($this->ip);
    }

    
    // FirstCheck function
    public function firstCheckIP(IPAddress $ip){
        if($this->isAliveIP($ip) == true){
            $ip->status = true;
        }
        else{
            dispatch(new DoubleCheckIPJob($ip))->onQueue('processing');
        }
        //Get execution time
        $cur = shell_exec('date +"%d/%m/%y, %T"');
   
        //Update value for ip
        ($ip->attempts == 0) ? $ip->first_check = $cur : '';
        $ip->attempts += 1;
        $ip->final_check = $cur;
        $ip->save();
    }

    //Check if IP alive or not 
    public function isAliveIP(IPAddress $ip){
        if($ip->port){ 
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            try{
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
