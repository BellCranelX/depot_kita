<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $table = 'customer'; // Ensure this matches the table name exactly
    protected $fillable = ['email', 'password', 'name'];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'customer_id');
    }
}
