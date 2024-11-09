<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class products extends Pivot
{
    public function order()
    {
        return $this->hasMany(orders::class, 'product_id');
    }
}
