<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$sellers = Seller::has('products')->get();
        // return response()->json(['data' => $sellers], 200);

        $sellers = Seller::all();
        return $this->showAll($sellers);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //return response()->json(['data' => $seller], 200);
        // $seller = Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }
}
