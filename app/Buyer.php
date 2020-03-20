<?php

namespace App;

use App\Scopes\BuyerScope;

class Buyer extends User
{

    /**
     * I an using this function in orther to user the
     * given Scope that modify the Elequent sql before excution
     * in order to use the implicite binding in contollers
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }
    public function transactions()
    {
        return  $this->hasMany(Transaction::class);
    }
}
