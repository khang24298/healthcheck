<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Model\IPAddress;
use App\Jobs\CheckHealthJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IPController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        // return Cache::remember('all_ip',300, function(){
        //     return IPAddress::all();
        // });
        return IPAddress::where('status',0)->get();
    }
    public function getIPSuccess(){
        $results = $this->index();
        foreach($results as $item){
            // CheckHealthJob::dispatch($item)
            dispatch(new CheckHealthJob($item));
        }
        
    }
    public function isAliveIP(IPAddress $ip){
        if($ip->port){ 
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            try{
                $result = socket_connect($socket, $ip->ip, $ip->port);
            }
            catch(Exception $e){
                // Log::info($e->getMessage());
                $result = false;
            }
        }
        else{
            exec("ping -c 1 -W 1 ".$ip->ip, $output);
            if(count($output) == 6){
                $result = true;
            }
            else{
                $result = false;
            }

        }
       
        return $result;
    }
    public function getIPFail(){

    }
    
    public function getIPInfo($id){

    }

    public function insertIP(Request $request){
        $ip = IPAddress::create($request->all());
        dispatch(new CheckHealthJob($ip));
        return;
    }
}
