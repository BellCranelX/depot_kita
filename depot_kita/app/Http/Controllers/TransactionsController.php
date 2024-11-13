<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Http\Request;
use App\Models\order_products;
use Illuminate\Support\Facades\Auth;



class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions =transactions::latest()->paginate(10);
        return view("admin.transaction.index", compact("transactions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transactions $transactions)
    {
        //
    }

    public function createTransaction(Request $request)
    {
        // Assuming the products and total price are passed from the frontend
        $cartItems = $request->input('cart'); // Array of cart items (product_id, quantity, price)
        $totalAmount = $request->input('total_price');
        $specialRequests = $request->input('special_requests', '');

        // Create the order record
        $order = orders::create([
            'customer_id' => Auth::guard('customer')->id(), // Get logged-in customer ID
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'special_requests' => $specialRequests,
            'waiting_list_number' => $this->generateWaitingListNumber(),
        ]);

        // Insert products into the order_product table
        foreach ($cartItems as $cartItem) {
            $product = products::find($cartItem['product_id']);
            $subtotal = $cartItem['quantity'] * $cartItem['price'];

            // Create the order_product record
            order_products::create([
                'order_id' => $order->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price'],
                'subtotal' => $subtotal,
            ]);
        }

        // Create the transaction record
        $transaction = transactions::create([
            'order_id' => $order->id,
            'amount' => $totalAmount,
            'payment_method' => 'Cash', // Replace with actual payment method from frontend
            'status' => 'paid', // Assuming the payment is successful
        ]);

        // Update the order status
        $order->status = 'paid';
        $order->save();

        return response()->json(['success' => 'Payment successful', 'transaction' => $transaction]);
    }

    private function generateWaitingListNumber()
    {
        // Example logic to generate a unique waiting list number
        return rand(1, 1000); // Replace with actual logic for generating waiting list number
    }
}
