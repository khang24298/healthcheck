<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Model\Supervisor;
use App\Jobs\RunSupervisorJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupervisorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index(){
        $sup = Supervisor::all();
        return view('supervisor',['data'=>$sup]);
    }

    public function create(){
        return view('supervisor-create');
    }

    public function show($id){
        $sup = Supervisor::findOrFail($id);
        return view('supervisor-edit',['data'=>$sup]);
    }

    public function store(Request $request){
        // dd($request);
        try {  
            // Laravel-worker.conf modification
            $sup = new Supervisor();
            $sup->program_name = $request['program_name'];
            $sup->autostart = ($request['auto_start'] == "on") ? true : false;
            $sup->autorestart = ($request['auto_restart'] == "on") ? true : false;
            ($request['stopwaitsecs'] != "") ? $sup->stopwaitsecs = $request['stopwaitsecs'] : ""; 
            ($request['num_procs'] != "") ? $sup->numprocs = $request['num_procs'] : "";
            ($request['sleep'] != "") ? $sup->sleep = $request['sleep'] : "";
            $sup->file_exec = "supervisor/exec/".$sup->program_name.".sh";
            ($request['tries'] != "") ? $sup->tries = $request['tries'] : "";
            ($request['queue'] != "") ? $sup->queue = $request['queue'] : "";
            ($request['timeout'] != "") ? $sup->timeout = $request['timeout'] : "";

            $sup->save();
            return redirect()->back();  
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function runSupervisor($id){
        $sup = Supervisor::findOrFail($id);
        dispatch(new RunSupervisorJob($sup));
        return 1;
    }
    public function update(Request $request){
        // dd($request);
        try{
            $sup = Supervisor::find($request['id']);
            $sup->program_name = $request['program_name'];
            $sup->autostart = ($request['auto_start'] == "on") ? true : false;
            $sup->autorestart = ($request['auto_restart'] == "on") ? true : false;
            ($request['stopwaitsecs'] != "") ? $sup->stopwaitsecs = $request['stopwaitsecs'] : ""; 
            ($request['num_procs'] != "") ? $sup->numprocs = $request['num_procs'] : "";
            ($request['sleep'] != "") ? $sup->sleep = $request['sleep'] : "";
            $sup->file_exec = "supervisor/exec/".$sup->program_name.".sh";
            ($request['tries'] != "") ? $sup->tries = $request['tries'] : "";
            ($request['queue'] != "") ? $sup->queue = $request['queue'] : "";
            ($request['timeout'] != "") ? $sup->timeout = $request['timeout'] : "";
            $sup->save();
            return $sup;
        }
        catch(\Throwable $th){
            return $th->getMessage();
        }
         
    }

    public function delete($sup){
         
    }
}
