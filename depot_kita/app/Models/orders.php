<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'customer_id', 'order_date', 'status', 'waiting_list_number', 'total_amount', 'special_requests', 'updated_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); // Fixed the foreign key to 'customer_id'
    }

    public function transactions()
    {
        return $this->hasMany(transactions::class, 'order_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(order_products::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(products::class, 'order_products', 'order_id', 'product_id')->withPivot('quantity', 'price', 'subtotal');
    }
}
