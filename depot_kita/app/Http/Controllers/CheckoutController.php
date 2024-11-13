<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\order_products;
use App\Models\transactions;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // public function processOrder(Request $request)
    // {
    //     // Validate incoming request data
    //     $request->validate([
    //         'cart' => 'required|array',
    //         'total_price' => 'required|numeric',
    //     ]);

    //     // Create an order record
    //     $order = orders::create([
    //         'user_id' => Auth::guard('customer')->id(),
    //         'total_price' => $request->total_price,
    //         'status' => 'pending', // or another status depending on your flow
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     // Insert the order products
    //     foreach ($request->cart as $item) {
    //         order_products::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item['product_id'],
    //             'quantity' => $item['quantity'],
    //             'price' => $item['price'],
    //             'special_request' => $item['special_request'] ?? null, // Handle special request
    //         ]);
    //     }

    //     // Create a transaction record (assuming you're processing a payment)
    //     $transaction = transactions::create([
    //         'order_id' => $order->id,
    //         'amount' => $request->total_price,
    //         'status' => 'pending', // or 'completed' after payment is processed
    //         'payment_method' => 'credit_card', // Update this based on actual payment method
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Order placed successfully',
    //     ]);
    // }
}
