@extends('admin/admin_navbar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 mt-4 btn-group">
            <h1>Edit Order Details</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Order Summary</h3>
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
                    <td>{{ $orderData->customer->name }}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{ $orderData->order_date }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>{{ number_format($orderData->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Special Requests</th>
                    <td>{{ $orderData->special_requests ?? 'None' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <form action="{{ route('orders.update', ['order' => $orderData->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control">
                                <option value="pending" {{ $orderData->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $orderData->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $orderData->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $orderData->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                        </form>
                    </td>
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
                        <td>{{ $product->product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ number_format($product->subtotal, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d F Y H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->updated_at)->format('d F Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7">No products found for this order.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection