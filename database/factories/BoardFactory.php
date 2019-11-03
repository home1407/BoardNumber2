<?php

use Faker\Generator as Faker;
use App\User; //import 

$factory->define(App\Board::class, function (Faker $faker) {
    $minId = App\User::min('id');  //select min('id') from User , User::min('id')
    $maxId = App\User::max('id');
    return [
        'title' => $faker->word(10),
        'content' => $faker->sentence,
        'user_id' => $faker->numberBetween($minId,$maxId),
    ];
});
