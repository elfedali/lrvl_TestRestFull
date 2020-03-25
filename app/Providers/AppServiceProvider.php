<?php

namespace App\Providers;

use App\Product;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //Schema::defaultStringLength(191);

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
    public function register()
    {
        //
    }
}
