<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class customers extends Pivot
{
    public function order()
    {
        return $this->hasMany(Orders::class, 'customer_id');
    }
}
