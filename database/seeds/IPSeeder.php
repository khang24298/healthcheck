<?php

use App\Http\Controllers\Model\IPAddress;
use Illuminate\Database\Seeder;

class IPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(IPAddress::class,1000)->create();
    }
}
