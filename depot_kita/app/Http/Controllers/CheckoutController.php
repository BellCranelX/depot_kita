<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        // Retrieve total_price from URL parameter
        $total_price = $request->query('total_price', 0); // Default to 0 if not present
        return view('checkout', compact('total_price'));
    }
}
