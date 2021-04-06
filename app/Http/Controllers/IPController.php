<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Model\IPAddress;
use App\Jobs\CheckHealthJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

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

    public function testIP(Request $request){
        $results = IPAddress::all();
        foreach($results as $result){
            if($this->firstCheckIP($result)){
                echo "\n".$result->ip;
                echo "\n".$result->status;
            }
        }
        // return $result;
    }
    // public function firstCheckIP(IPAddress $ip){
    //     if($this->isAliveIP($ip) == true){
    //         $ip->status = true;
    //     }
    //     //Get execution time
    //     $cur = now();
   
    //     //Update value for ip
    //     ($ip->attempts == 0) ? $ip->first_check = $cur : '';
    //     $ip->attempts += 1;
    //     $ip->final_check = $cur;
    //     $ip->isChecking = false;
    //     $ip->save();
    // }

    //Check if IP alive or not 
    public function isAliveIP(IPAddress $ip){
        if($ip->port){ 
            
            try{
                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                $result = socket_connect($socket, $ip->ip, $ip->port);
            }
            catch(Exception $e){
                $result = false;
            }
        }
        else{
            try{
                $output = shell_exec("ping -c 8 -W 1 ".$ip->ip);
                $outputs = explode("\n",$output);
                $char = "round-trip";
                foreach($outputs as $test){
                    if (strpos($test, $char) !== false) {
                        return true;
                    }
                }
                return false;
            }
            catch(Exception $e){
                $result = false;
            }
        }
        return $result;
    }
    public function index(){
        try{
            $results = Cache::remember('all_ip',300, function(){
                return IPAddress::all();
                ;
            });
            $mess = "success";
            $code = 200;
        }
        catch(Exception $e){
            $mess = $e->getMessage();
            $code = 500;
        }
        // dd($results);
        return view('home',['data'=>$results]);
    }


    public function checkIP(){
        $results = Cache::remember('all_ip',300, function(){
            return IPAddress::all();
        });
        foreach($results as $item)
        {
            $job = (new CheckHealthJob($item))->onQueue('first');
            dispatch($job);
        };
        return "Checking IP is in process";
    }
    
    public function getIPSuccess(){
        try{
            $results = Cache::remember('success_ip',300,function(){
                return IPAddress::where('status',1)->get();
            });
            $mess = "success";
        }
        catch(Exception $e){
            $mess = $e->getMessage();
            $code = 500;
        }
        return response()->json([
            'message' => $mess,
            'data' => $results
        ],$code);
    }
    public function getIPFail(){
        try{
            $results = Cache::remember('success_ip',300,function(){
                return IPAddress::where('status',0)->get();
            });
            $mess = "success";
        }
        catch(Exception $e){
            $mess = $e->getMessage();
            $code = 500;
        }
        return response()->json([
            'message' => $mess,
            'data' => $results
        ],$code);
    }
    
    public function getIPInfo($ip){
        try{
            $results = Cache::remember('ip:'.$ip,300,function() use ($ip){
                return IPAddress::where('ip',$ip)->get();
            });
            $mess = "success";
        }
        catch(Exception $e){
            $mess = $e->getMessage();
            $code = 500;
        }
        return response()->json([
            'message' => $mess,
            'data' => $results
        ],$code);
    }

    public function insertIP(Request $request){
        // dd($request);
        try{
            if($request->range != ""){
                $ip_count = 1 << (32 - $request->range);
                $start = ip2long($request->ip);
                for ($i = 0; $i < $ip_count; $i++) {
                    $ipadd = long2ip($start + $i);
                    if($request->portTo != "" && $request->portFrom != ""){
                        for($j = $request->portFrom; $j<= $request->portTo; $j++){
                            $ip = new IPAddress();
                            $ip->ip = $ipadd;
                            $ip->port = $j;
                            $ip->range = $request->range;
                            $ip->save();
                            $job = (new CheckHealthJob($ip))->onQueue('first');
                            dispatch($job);
                        }
                    }
                    else if($request->portTo != "" || $request->portFrom != ""){
                        $ip = new IPAddress();
                        $ip->ip = $ipadd;
                        $ip->port = ($request->portTo != "") ? $request->portTo : $request->portFrom;
                        $ip->range = $request->range;
                        $ip->save();
                        $job = (new CheckHealthJob($ip))->onQueue('first');
                        dispatch($job);
                    }
                    else{
                        $ip = new IPAddress();
                        $ip->ip = $ipadd;
                        $ip->range = $request->range;
                        $ip->save();
                        $job = (new CheckHealthJob($ip))->onQueue('first');
                        dispatch($job);
                    }
                }
            }
            else{
                if($request->portTo != "" && $request->portFrom != ""){
                    for($j = $request->portFrom; $j<= $request->portTo; $j++){
                        $ip = new IPAddress();
                        $ip->ip = $request->ip;
                        $ip->port = $j;
                        $ip->save();
                        $job = (new CheckHealthJob($ip))->onQueue('first');
                        dispatch($job);
                    }
                }
                else if($request->portTo != "" || $request->portFrom != ""){
                    $ip = new IPAddress();
                    $ip->ip = $request->ip;
                    $ip->port = ($request->portTo != "") ? $request->portTo : $request->portFrom;
                    $ip->save();
                    $job = (new CheckHealthJob($ip))->onQueue('first');
                    dispatch($job);
                }
                else{
                    $ip = new IPAddress();
                    $ip->ip = $request->ip;
                    $ip->save();
                    $job = (new CheckHealthJob($ip))->onQueue('first');
                    dispatch($job);
                }
            }
            $mess = "success";
            $code = 200;
        }
        catch(Exception $e){
            $mess = $e->getMessage();
            $code = 500;
        }
        return response()->json([
            'message' => $mess,
            'data' => $ip
        ],$code);
    }
}
