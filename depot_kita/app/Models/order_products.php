<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class order_products extends Pivot

{
    protected $table = "order_products";
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];
    public function order()
    {
        return $this->belongsTo(orders::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
