<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Http\Request;
use App\Models\order_products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
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

            // Step 5: Create the transaction record
            $transaction = transactions::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_method' => $validatedData['payment_method'],
                'status' => 'pending',
            ]);

            DB::commit();

            // Step 7: Return success response
            return response()->json(['success' => true, 'message' => 'Order and transaction created successfully!']);
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
}
