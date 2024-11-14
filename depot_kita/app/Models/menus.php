<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menus extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'product';  // Ensure this matches your table name in the database

    // Define the fillable fields
    protected $fillable = ['name', 'description', 'price', 'stock', 'image'];
}
