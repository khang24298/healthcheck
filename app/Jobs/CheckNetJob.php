<?php

namespace App\Jobs;


class CheckNetJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $ip;
    public function __construct()
    {
        $this->ip = "127.0.0.1";
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
    }

    public function checkNet(){
        $ip = "http://proxy.hcm.fpt.vn:80";
        $url = "https://tinhte.vn";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_PROXY, $ip);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $timeout = 6;
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        echo $output;
        // var_dump(curl_getinfo($ch));
        curl_close($ch);
    }
}    
