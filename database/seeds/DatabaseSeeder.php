<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // $this->call(UsersTableSeeder::class);

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();


        DB::table('category_product')->truncate();

        $userQuantity  = 40;
        $categoriesQuantity = 10;
        $productQuantity = 30;
        $transactionQuantity = 10;

        factory(User::class, $userQuantity)->create();

        factory(Category::class, $categoriesQuantity)->create();

        factory(Product::class, $productQuantity)->create()->each(
            function ($product) {
                $catgegories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($catgegories);
            }
        );

        factory(Transaction::class, $transactionQuantity)->create();
        
    }
}
