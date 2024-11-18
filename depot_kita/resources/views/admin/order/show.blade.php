@extends('admin/admin_navbar')

@section('content')
<div class="container-fluid position-relative"
    style="{{ 'background: url(' . asset('asset/food.jpg') . ') no-repeat center center / cover; height: 100vh; padding: 20px;' }}">
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
        <div class="col-md-4 mt-4 btn-group">
            <h1>Order Details</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Order Summary</h3>
            <!-- Display main order details in a styled table -->
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Order ID</th>
                    <td>{{ $orderData->id }}</td>
                </tr>
                <tr>
                    <th>Customer ID</th>
                    <td>{{ $orderData->customer_id }}</td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td>{{$orderData->customer->name}}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{ $orderData->order_date }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $orderData->status }}</td>
                </tr>
                <tr>
                    <th>Waiting List Number</th>
                    <td>{{ $orderData->waiting_list_number }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>{{ number_format($orderData->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Special Requests</th>
                    <td>{{ $orderData->special_requests ?? 'None' }}</td>
                </tr>
            </table>

            <h3>Order Products</h3>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Menu ID</th>
                        <th>Menu Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orderData->orderProducts->isNotEmpty())
                    @foreach($orderData->orderProducts as $product)
                    <tr>
                        <td>{{ $product->product_id }}</td>
                        <td>{{$product->product->name}}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ number_format($product->subtotal, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d F Y H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->updated_at)->format('d F Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6">No products found for this order.</td>
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
    $(document).ready(function() {
        $('.table').DataTable();
    });
</script>
@endpush