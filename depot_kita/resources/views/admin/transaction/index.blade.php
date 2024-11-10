<!-- resources/views/transactions/index.blade.php -->

@extends('admin/admin_navbar') <!-- or your main layout -->

<script src="/assets/jquery.js"></script>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2  btn-group">
            <h1>List Transactions</h1>

        </div>
    </div>
    <table id="transactionData" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Transaction Date</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->order_id }}</td>
                <td>{{ $transaction->transaction_date }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->payment_method }}</td>
                <td>{{ $transaction->status }}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Action">
                        <a href="{{ route('transactions.show', [ "transaction" => $transaction->id ]) }}">
                            <button type="button" class="btn btn-sm btn-primary ml-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </a>
                        <a href="{{ route('transactions.edit', [ "transaction" => $transaction->id ]) }}">
                            <button type="button" class="btn btn-sm btn-warning mx-1">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </a>
                        <form action="{{ route('transactions.destroy', [ "transaction" => $transaction->id ]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger ml-1">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


<script src="DataTables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactionData').DataTable();
    });
</script>