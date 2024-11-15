<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .card {
      cursor: pointer;
      transition: transform 0.3s;
      height: 100%;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card-img-top {
      height: 200px;
      object-fit: cover;
    }

    @media (max-width: 576px) {
      .card-img-top {
        height: 150px;
      }
    }

    .out-of-stock {
      background-color: #f5f5f5;
      color: #888;
    }

    .out-of-stock .card-body {
      opacity: 0.5;
    }

    .out-of-stock .card-title,
    .out-of-stock .card-footer {
      color: red;
      font-weight: bold;
    }

    /* Style for cart items */
    #cartItems {
      max-height: 400px;
      overflow-y: auto;
    }

    #cartItems .list-group-item {
      border: 1px solid #e0e0e0;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    #cartItems .list-group-item .ms-2 button {
      margin-left: 5px;
    }

    .btn-warning {
      background-color: #ffc107;
      color: white;
    }

    .btn-danger {
      background-color: #dc3545;
      color: white;
    }

    .btn-warning:hover {
      background-color: #e0a800;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    .navbar {
      padding: 15px 0;
      /* Reduce the vertical padding */
    }

    .navbar-brand img {
      height: 70px;
      /* Adjust logo size if needed */
    }

    .navbar-nav .nav-item .nav-link {
      font-size: 14px;
      /* Reduce font size for the links */
    }

    .navbar-nav .nav-item .dropdown-toggle {
      font-size: 20px;
      /* Reduce font size for the dropdown */
    }

    .navbar .navbar-toggler-icon {
      width: 20px;
      /* Reduce the size of the toggle icon */
      height: 20px;
    }
  </style>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="{{route('customer.order')}}">
        <img src="{{ asset('logo/depot_kita.jpg') }}" alt="Logo"> Depot Kita
      </a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          @if (Auth::guard('customer')->check())
          <li class="nav-item dropdown">
            <!-- User Icon with Dropdown Toggle -->
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-regular fa-user"></i> Welcome, {{ Auth::guard('customer')->user()->name }}
            </a>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li>
                <a class="dropdown-item" href="{{ route('customer.profile') }}">Profile</a>
              </li>
              <li>
                <!-- Logout Form Triggered from Dropdown Item -->
                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
                <a class="dropdown-item" href="{{ route('customer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
                </a>
              </li>
            </ul>
          </li>
          @else
          <li class="nav-item">
            <a class="btn btn-primary" href="{{ route('customer.login') }}">Login</a>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      @foreach ($products as $product)
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="card {{ $product->stock == 0 ? 'out-of-stock' : '' }}" onclick="showModal('{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}')">
          <img src="{{ asset('menu/'.$product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text fw-bold">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
          </div>
          @if ($product->stock == 0)
          <div class="card-footer text-center">Out of Stock</div>
          @endif
        </div>
      </div>
      @endforeach
    </div>

    <h3 class="mt-5">Keranjang Belanja</h3>
    <ul id="cartItems" class="list-group mb-3"></ul>
    <p class="fw-bold">Total Harga: Rp <span id="totalPrice">0</span> <span class="badge bg-primary" id="cartItemCount">0</span></p>
    <button class="btn btn-success w-100 mt-3" onclick="redirectToCheckout()">Bayar</button>
  </div>

  <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="menuModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="quantity" class="form-label">Jumlah</label>
              <input type="number" class="form-control" id="quantity" min="1" value="1">
            </div>
            <div class="mb-3">
              <label for="specialRequests" class="form-label">Notes (optional)</label>
              <textarea class="form-control" id="specialRequests" rows="3"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    let cart = [];
    let selectedItem = {};

    function showModal(productId, productName, productPrice) {
      selectedItem = {
        id: productId,
        name: productName,
        price: productPrice
      };
      document.getElementById('menuModalLabel').textContent = productName;
      document.getElementById('quantity').value = 1;
      document.getElementById('specialRequests').value = '';
      new bootstrap.Modal(document.getElementById('menuModal')).show();
    }

    function addToCart() {
      const quantity = parseInt(document.getElementById('quantity').value);
      const specialRequest = document.getElementById('specialRequests').value;

      // Check if the item already exists in the cart
      const existingItemIndex = cart.findIndex(item => item.id === selectedItem.id);
      if (existingItemIndex !== -1) {
        // If item exists, update its quantity
        cart[existingItemIndex].quantity += quantity;
        cart[existingItemIndex].specialRequest = specialRequest;
      } else {
        // If item doesn't exist, add a new item to the cart
        const item = {
          ...selectedItem,
          quantity,
          specialRequest
        };
        cart.push(item);
      }

      updateCartDisplay();
      bootstrap.Modal.getInstance(document.getElementById('menuModal')).hide();
    }

    function removeFromCart(index) {
      cart.splice(index, 1);
      updateCartDisplay();
    }

    function updateCartDisplay() {
      const cartItemsContainer = document.getElementById('cartItems');
      cartItemsContainer.innerHTML = '';
      let totalPrice = 0;

      cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        totalPrice += itemTotal;
        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        listItem.innerHTML = `
        <div>
          <strong>${item.name}</strong> x ${item.quantity}
          <div><small>Special Request: ${item.specialRequest || 'None'}</small></div>
        </div>
        <span class="d-flex align-items-center">
          <strong>Rp ${itemTotal}</strong>
          <div class="ms-2">
            <button class="btn btn-sm btn-warning" onclick="decreaseQuantity(${index})">-</button>
            <button class="btn btn-sm btn-warning" onclick="increaseQuantity(${index})">+</button>
            <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${index})">Hapus</button>
          </div>
        </span>
      `;
        cartItemsContainer.appendChild(listItem);
      });

      document.getElementById('cartItemCount').textContent = cart.length;
      document.getElementById('totalPrice').textContent = totalPrice.toLocaleString('id-ID');
    }

    function decreaseQuantity(index) {
      if (cart[index].quantity > 1) {
        cart[index].quantity -= 1;
        updateCartDisplay();
      }
    }

    function increaseQuantity(index) {
      cart[index].quantity += 1;
      updateCartDisplay();
    }

    function redirectToCheckout() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const totalPrice = parseFloat(document.getElementById('totalPrice').textContent.replace(/\./g, '').replace('Rp ', ''));
      const cartItems = cart.map(item => ({
        id: item.id,
        quantity: item.quantity,
        special_request: item.specialRequest
      }));

      const customerId = "{{ Auth::guard('customer')->user()->id }}"; // Assuming the customer is logged in and their ID is available

      fetch('/checkout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({
            customer_id: customerId,
            products: cartItems,
            total_amount: totalPrice,
            payment_method: "Qris", // You can make this dynamic based on user selection
            special_requests: cartItems.map(item => item.special_request)
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Payment successful');
            window.location.href = "/customer/checkout"; // Redirect to a confirmation page
          } else {
            alert('Payment failed: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An unexpected error occurred during payment.');
        });
    }
  </script>


</body>

</html>