<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function submit(Request $request)
    {
        // Proses data pemesanan di sini
        return redirect()->route('order.page')->with('success', 'Pesanan berhasil dibuat!');
    }
}
