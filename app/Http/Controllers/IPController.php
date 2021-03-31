<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Model\IPAddress;
use App\Jobs\CheckHealthJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            return IPAddress::where('status',0)->get();
        });
        foreach($results as $item)
        {
            dispatch(new CheckHealthJob($item));
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
            $ip = new IPAddress();
            $ip->ip = $request->ip;
            $ip->port = $request->port;
            $ip->save();
            dispatch(new CheckHealthJob($ip));
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
