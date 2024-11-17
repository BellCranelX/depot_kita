@extends('admin/admin_navbar') <!-- or your main layout -->

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

    <!-- Main Content -->
    <div class="row position-relative" style="z-index: 1;">
        <div class="col-md-4 mt-4 btn-group">
            <h1>List Transactions</h1>
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
                <td style="background-color:#c2c5c5">{{ $transaction->id }}</td>
                <td style="background-color:#c2c5c5">{{ $transaction->order_id }}</td>
                <td style="background-color:#c2c5c5">{{ $transaction->transaction_date }}</td>
                <td style="background-color:#c2c5c5">{{ $transaction->amount }}</td>
                <td style="background-color:#c2c5c5">{{ $transaction->payment_method }}</td>
                <td style="background-color:#c2c5c5">{{ $transaction->status }}</td>
                <td style="background-color:#c2c5c5">
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
<!-- Load Bootstrap and DataTables CSS -->
<link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<!-- Load jQuery, Bootstrap, and DataTables JS -->
<script src="{{ asset('asset/jquery.js') }}"></script>
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#transactionData').DataTable();
    });
</script>
@endpush
