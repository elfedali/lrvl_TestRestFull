<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChange;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        //Schema::defaultStringLength(191);


        /**
         * Trigger this event when $user is created 
         */
        User::created(function ($user) {
            retry(5, function () use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 100);
        });

        /**
         * Trigger this event when $user is updated 
         */
        User::updated(function ($user) {
            if ($user->isDirty('email')) :
                retry(5, function()use ($user) {
                    Mail::to($user)->send(new UserMailChange($user));
                });
            endif;
        });


        /**
         * Trigger this event when $product is updated 
         */
        Product::updated(function ($product) {
            if ($product->quantity == 0 && $product->status == Product::AVAILABLE_PRODUCT) :
                $product->status = Product::UNAVAILABLE_PRODUCT;
                $product->save();
            endif;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
