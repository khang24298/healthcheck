<?php

namespace App\Jobs;

use App\Http\Controllers\Model\IPAddress;

class CheckNetJob extends Job
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
        $this->ip->isNetCheck = true;
        $this->ip->save();
        if($this->checkNet() !== false){
            $this->ip->isInternetConnect = true;
            $this->ip->isNetCheck = false;
            $this->ip->save();
        }
    }

    public function checkNet(){
        $proxy = ($this->ip->port) ? $this->ip->ip.":".$this->ip->port : $this->ip->ip;
        $url = "https://tinhte.vn";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $timeout = 6;
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}    
