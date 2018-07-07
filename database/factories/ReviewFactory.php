<?php
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
    	'product_id' => function(){ //THis part Here is like this because it is a foreign key

    		return Product::all()->random();
    	},
    	
        'customer' => $faker->name,
        'review' => $faker->paragraph,
        'star' => $faker->numberBetween(0,5)
    ];
});
