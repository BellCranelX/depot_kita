<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Models\Customers;
use App\Models\Products;
use App\Models\Transactions;

class orders extends Pivot
{
    //
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function transactions(){
        return $this->hasMany(Transactions::class,'order_id');
    }

    
}
