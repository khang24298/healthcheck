<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Controllers\Model\IPAddress;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(IPAddress::class, function (Faker $faker) {
    return [
        'ip' => rand(1,223).".".rand(0,255).".".rand(0,255).".".rand(0,255),
        'port' => rand(0,65353),
    ];
});
