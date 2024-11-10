@extends('admin/admin_navbar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2 btn-group">
            <h1>List Orders</h1>
        </div>
    </div>
    <table id="orderData" class="table table-striped display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Waiting Number</th>
                <th>Total Price</th>
                <th>Note</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr> 
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_id }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->waiting_list_number }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->special_requests }}</td>
                <td>{{ $order->status }}</td>
                <td>
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
