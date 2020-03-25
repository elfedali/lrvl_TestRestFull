<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        // validate request
        // check if the buyer is not the seller 
        // check that the buyer is verified
        // if the product is available 
        // if the requested quantity is greater than the product available product 
        // store new transaction
        // substract the quantity from the product quantity
        $rules = [
            'quantity' => 'required|integer|min:1',

        ];
        $this->validate($request, $rules);

        if ($buyer->id == $product->seller->id) :
            return $this->errorResponse('The buyer cant be the seller of this product', 409);
        endif;
        if (!$buyer->isVerified()) :
            return $this->errorResponse('The buyer must be a verified user', 409);
        endif;

        if (!$product->seller->isVerified()) :
            return $this->errorResponse('The seller must be a verified user', 409);
        endif;

        if (!$product->isAvailable()) :
            return $this->errorResponse('The product is not available', 409);
        endif;

        if ($request->quantity > $product->quantity) :
            return $this->errorResponse('The quantity requested is more than the available for this product', 409);
        endif;

        return DB::transaction(function () use ($request, $product, $buyer) {
            // Save the product
            $product->quantity -= (int) $request->quantity;
            $product->save();
            
            // Create the transaction 
            $data = [
                'quantity' =>  (int) $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ];

            $transaction = Transaction::create($data);
            return $this->showOne($transaction);
        });
    }
}
