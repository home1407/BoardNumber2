<?php

use Faker\Generator as Faker;
use App\Board;
use App\User;

$factory->define(App\Comment::class, function (Faker $faker) {
    $userMin = User::min('id');
    $userMax = User::max('id');
    $boardMin = Board::min('id');
    $boardMax = Board::max('id');
    return [
        'content' => $faker->sentence,
        'board_id' => $faker->numberBetween($boardMin, $boardMax),
        'user_id' => $faker->numberBetween($userMin, $userMax), // secret
    ];
});
