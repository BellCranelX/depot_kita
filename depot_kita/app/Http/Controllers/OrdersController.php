<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\products;
use App\Models\transactions;
use App\Models\order_products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::with('customer')->orderBy("created_at", "desc")->paginate(10); // Eager load customer relationship
        return view("admin.order.index", compact("orders"));
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
    public function show(string $id)
    {
        // Retrieve the order along with its related products (orderProducts)
        $orderData = orders::with('orderProducts', 'customer', 'products')->findOrFail($id);

        return view("admin.order.show", [
            "orderData" => $orderData
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orders $orders)
    {
        //
    }

    public function submit(Request $request)
    {
        // Proses data pemesanan di sini
        return redirect()->route('order.page')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function processCheckout(Request $request)
    {
        // Start a transaction for data consistency
        DB::beginTransaction();

        try {
            // Step 1: Validate the incoming request data
            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customer,id',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:product,id',
                'products.*.quantity' => 'required|integer|min:1',
                'payment_method' => 'required|in:Qris,Ovo,Gopay,Dana',
                'special_requests' => 'nullable|array',
            ]);

            // Step 2: Calculate the total amount for the order
            $totalAmount = 0;
            foreach ($validatedData['products'] as $product) {
                $price = products::find($product['id'])->price;
                $totalAmount += $price * $product['quantity'];
            }

            // Step 3: Create the order record
            $order = orders::create([
                'customer_id' => $validatedData['customer_id'],
                'status' => 'pending',
                'waiting_list_number' => $this->generateWaitingListNumber(),
                'total_amount' => $totalAmount,
                'special_requests' => json_encode($validatedData['special_requests']),
            ]);

            // Step 4: Create order_product records
            foreach ($validatedData['products'] as $product) {
                $price = products::find($product['id'])->price;
                order_products::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $price,
                    'subtotal' => $price * $product['quantity'],
                ]);
            }

            // Generate a unique order ID for Midtrans
            $uniqueOrderId = 'ORDER-' . $order->id . '-' . time();

            // Step 5: Create the transaction record
            $transaction = transactions::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_method' => $validatedData['payment_method'],
                'status' => 'pending',
            ]);

            // Configure Midtrans
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $customer = Auth::guard('customer')->user();
            if (!$customer) {
                return response()->json(['success' => false, 'message' => 'User not authenticated']);
            }

            $params = array(
                'transaction_details' => array(
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $totalAmount,
                ),
                'customer_details' => array(
                    'first_name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Save the Snap token
            $transaction->snap_token = $snapToken;
            $transaction->save();

            DB::commit();

            // Step 7: Return success response
            return response()->json(['success' => true, 'message' => 'Order and transaction created successfully!', 'snapToken' => $snapToken]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Transaction failed: ' . $e->getMessage()]);
        }
    }



    private function generateWaitingListNumber()
    {
        // Generate a unique waiting list number logic
        return orders::max('waiting_list_number') + 1;
    }

    public function checkout(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please log in to access the checkout page.');
        }

        $products = products::whereIn('id', session('cart', []))->get();

        // Get pending transactions for this customer
        $transactions = transactions::whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->where('status', 'pending')->get();

        return view('customer.checkout', compact('products', 'transactions'));
    }

    public function success(Request $request)
    {
        // Find the transaction using the provided Snap token
        $transaction = transactions::where('snap_token', $request->input('token'))->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
        }

        // Check if the transaction is already completed
        if ($transaction->status === 'completed') {
            return response()->json([
                'success' => true,
                'transaction_id' => $transaction->id,
                'waiting_list_number' => $transaction->order->waiting_list_number,
                'message' => 'Transaction already completed.'
            ]);
        }

        // Update transaction status to 'completed'
        $transaction->status = 'completed';
        $transaction->save();

        // Decrease stock for each product in the order
        $order = $transaction->order; // Get the related order
        foreach ($order->orderProducts as $orderProduct) {
            $product = $orderProduct->product; // Retrieve the product
            if ($product) {
                // Decrease the product stock
                $product->stock = max(0, $product->stock - $orderProduct->quantity);
                $product->save();
            }
        }

        // Return a JSON response with the waiting list number
        return response()->json([
            'success' => true,
            'transaction_id' => $transaction->id,
            'waiting_list_number' => $order->waiting_list_number,
            'message' => 'Transaction completed successfully.'
        ]);
    }

}
