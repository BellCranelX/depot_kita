<!-- resources/views/transactions/index.blade.php -->

@extends('admin/admin_navbar') <!-- or your main layout -->

@section('content')
<div class="container">
    <h1 class="mb-4">Transactions</h1>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Transaction Number</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Transaction Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->transaction_number }}</td>
                    <td>${{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d H:i:s') }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
