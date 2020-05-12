<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' =>$faker->word,
        'details' =>$faker->paragraph,
        'price' =>$faker->numberBetween(100,1000),
        'stock' =>$faker->randomDigit,
        'discount' =>$faker->numberBetween(2,30),
        'user_id' => $faker->numberBetween(1,5),
    ];
});
