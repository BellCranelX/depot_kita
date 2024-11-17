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

    <!-- Main Content -->
    <div class="row position-relative" style="z-index: 1;">
        <div class="col-md-4 mt-4 btn-group">
            <h1>List Orders</h1>
        </div>
    </div>
    
    <table id="orderData" class="table table-striped table-bordered position-relative" style="z-index: 1;">
        <thead>
            <tr>
                <th style="background-color:#9b9e9e">ID</th>
                <th style="background-color:#9b9e9e">Customer ID</th>
                <th style="background-color:#9b9e9e">Customer Name</th>
                <th style="background-color:#9b9e9e">Order Date</th>
                <th style="background-color:#9b9e9e">Waiting Number</th>
                <th style="background-color:#9b9e9e">Total Price</th>
                <th style="background-color:#9b9e9e">Note</th>
                <th style="background-color:#9b9e9e">Status</th>
                <th style="background-color:#9b9e9e">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td style="background-color:  #c2c5c5">{{ $order->id }}</td>
                <td style="background-color:  #c2c5c5">{{ $order->customer_id }}</td>
                <td style="background-color:  #c2c5c5">{{ $order->customer->name }}</td>
                <td style="background-color:  #c2c5c5">{{ $order->order_date }}</td>
                <td style="background-color:  #c2c5c5">{{ $order->waiting_list_number }}</td>
                <td style="background-color:  #c2c5c5">{{ $order->total_amount }}</td>
                <td style="background-color:  #c2c5c5">{{ $order->special_requests }}</td>
                <td style="background-color:  #c2c5c5">{{ $order->status }}</td>
                <td style="background-color:  #c2c5c5">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Action">
                        <a href="{{ route('orders.show', [ "order" => $order->id ]) }}">
                            <button type="button" class="btn btn-sm btn-primary ml-1">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </a>
                        <a href="{{ route('orders.edit', [ "order" => $order->id ]) }}">
                            <button type="button" class="btn btn-sm btn-warning mx-1">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </a>
                        <form action="{{ route('orders.destroy', [ "order" => $order->id ]) }}" method="POST" style="display:inline;">
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
        $('#orderData').DataTable();
    });
</script>
@endpush
