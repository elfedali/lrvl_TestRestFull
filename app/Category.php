<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'description',

    ];
    protected $hidden = [
        'pivot'  // hide this is the json results ex: /api/categories/1/products
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
