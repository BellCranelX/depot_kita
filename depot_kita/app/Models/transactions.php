<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_date',
        'amount',
        'payment_method',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(orders::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); // Fixed to 'customer_id'
    }
}
