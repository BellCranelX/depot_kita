<?php

namespace App\Http\Controllers;
use App\Models\orders;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Http\Request;
use App\Models\order_products;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function submit(Request $request)
    {
        // Proses data pemesanan di sini
        return redirect()->route('order.page')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function processCheckout(Request $request)
    {

        dd($request->all());
        $request->validate([
            'cart' => 'required|array',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);
    
        $customer = auth()->guard('customer')->user();
    
        try {
            DB::transaction(function () use ($request, $customer) {
                $order = orders::create([
                    'customer_id' => $customer->id,
                    'order_date' => now(),
                    'status' => 'pending',
                    'total_amount' => $request->total_price,
                ]);
    
                foreach ($request->cart as $cartItem) {
                    $product = products::findOrFail($cartItem['product_id']);
                    if ($product->stock < $cartItem['quantity']) {
                        throw new \Exception("Product {$product->name} is out of stock.");
                    }
    
                    $product->decrement('stock', $cartItem['quantity']);
    
                    order_products::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem['product_id'],
                        'quantity' => $cartItem['quantity'],
                        'price' => $cartItem['price'],
                        'special_request' => $cartItem['special_request'] ?? '',
                    ]);
                }
    
                transactions::create([
                    'order_id' => $order->id,
                    'transaction_date' => now(),
                    'amount' => $request->total_price,
                    'status' => 'completed',
                ]);
            });
    
            return response()->json(['success' => true, 'message' => 'Order processed successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment failed: ' . $e->getMessage()
            ], 500);
        }
    }
}    