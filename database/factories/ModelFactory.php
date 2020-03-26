<?php

use App\Category;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token' =>  $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin' => $faker->randomElement([User::ADMIN_USER, User::REGULAR_USER]),

    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker $faker)
{
    
    return [
        'name' => $faker->word(),
        'description' => $faker->paragraph(1),
        'quantity'=> $faker->numberBetween(1,10),
        'status'=> $faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
        'image'=> $faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
        'seller_id' => User::all()->random()->id,  // or 'seller_id' =>  User::inRandomOrder()->first()->id,
    ];
});

$factory->define(Transaction::class, function (Faker $faker)
{
    $seller = Seller::has('products')->get()->random(); // get users who have products 

    $buyer = User::all()->except($seller->id)->random(); //all user except the seller 

    $product = '';

    return[
        'quantity'=>$faker->numberBetween(1,10),
        'buyer_id'=> $buyer->id,
        'product_id'=> $seller->products->random()->id,

    ];
});
