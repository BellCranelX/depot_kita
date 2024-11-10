@extends('admin/admin_navbar')

@section('content')
<div class="container">
<div class="row">
        <div class="col-md-2 btn-group">
            <h1>List Orders</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Order Details</h3>
            <!-- Add table classes for Bootstrap styling -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orderData && $orderData->isNotEmpty())
                    @foreach($orderData as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->product_id }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->price, 2) }}</td>
                        <td>{{ number_format($order->subtotal, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->updated_at)->format('d F Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">No order data available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
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
    $(document).ready(function() {});
</script>
@endpush
