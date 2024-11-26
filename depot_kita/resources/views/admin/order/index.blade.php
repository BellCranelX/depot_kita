@extends('admin/admin_navbar')

@section('content')

<div class="mt-4">
<div class="container-fluid position-relative"
    style="background: url('{{ asset('asset/food.jpg') }}') no-repeat center center / cover; height: 100vh; padding: 20px;">
    <div class="position-absolute"
        style="background: rgba(255, 255, 255, 0.5); top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;">
    </div>

    <!-- Filter Form -->

    <form method="GET" action="{{ route('orders.index') }}" class="row position-relative" style="z-index: 1;">
        <div class="col-md-3">
            <select name="customer_name" id="customer_name" class="form-control">
                <option value="">All Customers</option>
                @foreach ($customers as $customer)
                <option value="{{ $customer->name }}"
                    {{ request('customer_name') == $customer->name ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="text" name="product" class="form-control" placeholder="Product Name"
                value="{{ request('product') }}">
        </div>

        <div class="col-md-3">
            <select name="status" id="status" class="form-control">
                <option value="">All Status</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Apply Filter</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    <!-- Result Count -->
    <div class="row mt-3">
        <div class="col text-black font-bold">
            <p>
                Showing <strong>{{ $orders->count() }}</strong> of 
                <strong>{{ $orders->total() }}</strong> results.
            </p>
        </div>
    </div>

    <!-- Orders Table -->
    <table id="orderData" class="table table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
</div>
@endsection
