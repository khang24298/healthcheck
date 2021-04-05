<?php

namespace App\Jobs;

use App\Http\Controllers\Model\Supervisor;
use Illuminate\Support\Facades\Log;

class RunSupervisorJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $sup;
    public function __construct(Supervisor $sup)
    {
        $this->sup = $sup;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        shell_exec('php /Users/mac/Sites/healthcheck/artisan --queue=high queue:listen');
        $this->runSupervisor($this->sup);
    }

    public function monitorTemplate(Supervisor $sup)
    {
        $autostart = ($sup->autostart == 1) ? "true" : "false";
        $autorestart = ($sup->autorestart == 1) ? "true" : "false";
        $template = 
                "\n\n".
                "[program:".$sup->program_name."]\n"
                ."process_name=%(program_name)s_%(process_num)02d\n"
                ."command=".$sup->file_exec."\n"
                ."autostart=".$autostart."\n"
                ."autorestart=".$autorestart."\n"
                ."numprocs=".$sup->numprocs."\n"
                ."redirect_stderr=true\n"
                ."stdout_logfile=/Users/mac/Sites/healthcheck/storage/logs/worker/worker.log\n"
                ."stopwaitsecs=".$sup->stopwaitsecs;
        return $template;
    }

    public function execFile(Supervisor $sup){
        $sleep = ($sup->sleep) ? " --sleep=".$sup->sleep : "";
        $tries = ($sup->tries) ? " --tries=".$sup->tries : "";
        $queue = ($sup->queue) ? " --queue=".$sup->queue : "";
        $timeout = ($sup->timeout) ? " --timeout=".$sup->timeout : "";
        $exec_file =
                "#!/bin/bash\n".
                "php /Users/mac/Sites/healthcheck/artisan "
                .$sleep
                .$tries
                .$queue
                .$timeout
                ." queue:listen";
        return $exec_file;
    }

    public function runSupervisor(Supervisor $sup){
        // dd()
        try{
            $content_conf = $this->monitorTemplate($sup);
            // dd($content_conf);
            $conf = fopen("supervisor/conf.d/laravel-worker.conf", "w") or die("Unable to open file!");
            file_put_contents("supervisor/conf.d/laravel-worker.conf", $content_conf, FILE_APPEND | LOCK_EX);
            fclose($conf);
            // Execute file modification
            $content_exec = $this->execFile($sup);
            
            $exec_file = fopen($sup->file_exec, "w") or die("Unable to open file!");
            fwrite($exec_file, $content_exec);
            fclose($exec_file);
            // Update supervisor and run file
            shell_exec('supervisorctl reread');
            shell_exec('supervisorctl update');
            shell_exec('chmod +x '.$sup->file_exec);
            shell_exec("supervisorctl start all");
        }
        catch(\Throwable $th){
            Log::info($th->getMessage());
        }
        
    }
}
