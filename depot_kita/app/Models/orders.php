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
        return $this->belongsTo(Customer::class, 'user_id');
    }


    public function transactions(){
        return $this->hasMany(Transactions::class,'order_id');
    }

    public function products_id(){
        return $this->hasMany(Products::class,'id');
    }

    public function orderItems(){
        return $this->hasMany(order_products::class,'id');
    }

    public function orderProducts(){
        return $this->hasMany(Products::class,'id');
    }
    
}
