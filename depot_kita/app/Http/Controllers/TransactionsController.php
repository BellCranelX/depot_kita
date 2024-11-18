<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\orders;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Http\Request;
use App\Models\order_products;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = transactions::query();

    // Apply status filter if provided
    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    }

    // Apply date range filter if provided
    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        // Extend the end_date to include the entire day
        $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());
    }

    // Retrieve filtered transactions
    $transactions = $query->get();

    // Calculate total amount for the filtered transactions
    $totalAmount = $transactions->sum('amount');

    return view('admin.transaction.index', compact('transactions', 'totalAmount'));
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
}
