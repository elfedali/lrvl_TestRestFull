<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transactions = $category->products()
        ->whereHas('transactions') // Obtain only products with at least one transaction, ignore the non selled ones 
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        -> collapse()
        ;
        return $this->showAll($transactions);
    }

}
