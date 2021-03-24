<?php

namespace App\Http\Controllers;
use App\Http\Controllers\IPController;
use App\Http\Controllers\Model\IPAddress;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $ip;
    public function __construct()
    {
        $this->ip = IPAddress::find(94);
    }

    public function index(){
         //Create instance of IPController
         $ctrl = new IPController();
         // Handle if IP is alive or not
        //  dd($ctrl->isAliveIP($this->ip));
         if($ctrl->isAliveIP($this->ip) === true){
             $this->ip->status = true;
         }
    }
}
