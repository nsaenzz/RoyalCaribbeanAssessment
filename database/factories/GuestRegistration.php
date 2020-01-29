<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\GuestRegistration::class, function (Faker $faker) {
    return [
        'personal_id' => $faker->unique()->random_int(7, 7),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email_address' => $faker->unique()->safeEmail,
        'brand' => $faker->randomElement($array = array ('R','Z','Z')),
        'email_list_flag' => $faker->boolean ,
        'ship' => $faker->text($maxNbChars = 100) ,
        'sail_date' => $faker->date($format = 'Y-m-d', $min = 'now'),
        'comments' => $faker->text($maxNbChars = 500) 
    ];
});
