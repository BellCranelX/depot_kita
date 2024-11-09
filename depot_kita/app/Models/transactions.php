<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class transactions extends Pivot
{
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'user_id');
    }

    public function orders()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
