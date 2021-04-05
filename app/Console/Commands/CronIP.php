<?php

namespace App\Console\Commands;

use App\Http\Controllers\Model\IPAddress;
use Illuminate\Console\Command;
use App\Jobs\CheckHealthJob;
use Illuminate\Support\Facades\Cache;

class CronIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronip:update';

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
        $results = Cache::remember('all_ip',300,function(){
            return IPAddress::where('status',0)->get();
        });
        foreach($results as $item)
        {
            if($item->status == 0){
                // dd($item);
                dispatch(new CheckHealthJob($item));
            }
        };
    }
}
