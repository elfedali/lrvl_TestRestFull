<?php

namespace App;

class Seller extends User
{
    public function producs()
    {
        return $this->hasMany(Product::class);
    }
}
