@extends('admin/admin_navbar')

@section('content')
<body>
  <div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
    @foreach ($menus as $menu)
    @if ($menu->active == 1) <!-- Only show active items -->
        <div class="col-md-4">
            <div class="card h-100"> <!-- Ensure card takes up full height -->
                <img src="{{ asset('asset/' . $menu->image_url) }}" class="card-img-top" alt="{{ $menu->name }}">
                <div class="card-body d-flex flex-column" style="height: 300px;"> <!-- Fixed height for the card body -->
                    <h5 class="card-title">{{ $menu->name }}</h5>
                    
                    <!-- Scrollable description -->
                    <p class="card-text description" style="flex-grow: 1; max-height: 100px; overflow-y: auto;">
                        {{ $menu->description }}
                    </p> <!-- Truncate description if it's too long -->
                    
                    <p class="card-text"><strong>Price:</strong> Rp.{{ number_format($menu->price, 2) }}</p>
                    <p class="card-text"><strong>Stock:</strong> {{ $menu->stock }}</p>

                    <!-- Active/Inactive Status -->
                    <p class="card-text">
                        <strong>Status:</strong> 
                        @if ($menu->active == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </p>

                    <!-- Delete Button (changes active status to 0) -->
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this menu item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-auto">Delete</button> <!-- mt-auto to push button to the bottom -->
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach




    </div>

    <button class="btn btn-primary mb-4 mt-4" data-bs-toggle="modal" data-bs-target="#addMenuModal">
        Add New Menu Item
    </button>

    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMenuModalLabel">Add New Menu Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="productPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="productImage" name="image" required>
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="productStock" name="stock" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
