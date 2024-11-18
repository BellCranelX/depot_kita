@extends('admin/admin_navbar')

@section('content')
<div class="container-fluid position-relative"
    style="background: url('{{ asset('asset/food.jpg') }}') no-repeat center center / cover; 
            height: 100vh; 
            padding: 20px;">
    <!-- Semi-transparent overlay -->
    <div class="position-absolute"
        style="background: rgba(255, 255, 255, 0.5); 
                top: 0; 
                left: 0; 
                width: 100%; 
                height: 100%; 
                pointer-events: none;">
    </div>
    <div class="row">
        <div class="col-md-8 mt-4">
            <h1>List Transactions</h1>
        </div>
        <div class="col-md-4 mt-4">
            <form action="{{ route('transactions.index') }}" method="GET" class="d-flex align-items-center">
                <label for="status" class="mr-2">Status:</label>
                <select name="status" id="status" class="form-control mr-2">
                    <option value="" disabled selected>Select a status</option>
                    <option value="completed" {{ request('status', 'completed') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>

                <label for="start_date" class="mr-2">From:</label>
                <input type="date" name="start_date" class="form-control mr-2" value="{{ request('start_date') }}">

                <label for="end_date" class="mr-2">To:</label>
                <input type="date" name="end_date" class="form-control mr-2" value="{{ request('end_date') }}">

                <button type="submit" class="btn btn-primary mr-2">Filter</button>

                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Clear Filters</a>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h5>Total Transactions: <span class="">Rp {{ number_format($totalAmount, 2) }}</span></h5>
        </div>
    </div>

    <table id="transactionData" class="table table-striped table-bordered position-relative" style="z-index: 1;">
        <thead>
            <tr>
                <th style="background-color:#9b9e9e">ID</th>
                <th style="background-color:#9b9e9e">Order ID</th>
                <th style="background-color:#9b9e9e">Transaction Date</th>
                <th style="background-color:#9b9e9e">Amount</th>
                <th style="background-color:#9b9e9e">Payment Method</th>
                <th style="background-color:#9b9e9e">Status</th>
                <th style="background-color:#9b9e9e">Action</th>
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
                        <a href="{{ route('transactions.show', ['transaction' => $transaction->id]) }}">
                            <button type="button" class="btn btn-sm btn-primary ml-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </a>
                        <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">
                            <button type="button" class="btn btn-sm btn-warning mx-1">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </a>
                        <form action="{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}" method="POST" style="display:inline;">
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

@push('head')
<link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('asset/jquery.js') }}"></script>
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#transactionData').DataTable();
    });
</script>
@endpush