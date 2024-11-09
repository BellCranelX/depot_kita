<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class order_products extends Pivot
{
    //
    public function order()
    {
        return $this->belongsTo(orders::class, 'order_id');
    }

    
}
