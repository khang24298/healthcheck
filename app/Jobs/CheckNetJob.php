<?php

namespace App\Jobs;

use App\Http\Controllers\Model\IPAddress;
use Exception;

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
            $this->ip->net_access_times += 1;
            $this->ip->save();
        }
        else{
            $this->ip->isNetCheck = false;
            $this->ip->save();
            throw new Exception("Error while check net ",1);
        }
    }

    public function checkNet(){
        $timeout = 30;
        $url = "https://tinhte.vn";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $this->ip);
        if($this->ip->port){
            curl_setopt($ch, CURLOPT_PROXYPORT, $this->ip->port);
        }
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}    
