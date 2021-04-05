<?php

namespace App\Console\Commands;

use App\Http\Controllers\Model\IPAddress;
use Illuminate\Console\Command;
use App\Jobs\CheckHealthJob;
use App\Jobs\DoubleCheckIPJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class DoubleCheckIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronip:doublecheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make PDF Patch from ClientGroup and TestDate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = DB::table('jobs')->count();
        if($count == 0){
            $results = Cache::remember('all_ip',300,function(){
                return IPAddress::where('status',0)->get();
            });
            foreach($results as $item)
            {
                dispatch(new DoubleCheckIPJob($item))->onQueue('processing');
            };
        }
        
    }
}
