<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
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
  </style>
</head>
<body>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="card" onclick="showModal('Nasi Goreng', 25000)">
        <img src="{{ asset('asset/nasgor.jpg') }}" class="card-img-top" alt="Nasi Goreng">
        <div class="card-body">
          <h5 class="card-title">Nasi Goreng</h5>
          <p class="card-text">Delicious fried rice with a special blend of spices.</p>
          <p class="card-text fw-bold">Harga: Rp 25,000</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="card" onclick="showModal('Mie Ayam', 20000)">
        <img src="{{ asset('asset/migor.jpg') }}" class="card-img-top" alt="Mie Ayam">
        <div class="card-body">
          <h5 class="card-title">Mie Ayam</h5>
          <p class="card-text">Savory chicken noodles with rich broth.</p>
          <p class="card-text fw-bold">Harga: Rp 20,000</p>
        </div>
      </div>
    </div>
    <!-- Tambahkan lebih banyak card sesuai menu -->
  </div>

  <!-- Cart Section -->
  <h3 class="mt-5">Keranjang Belanja</h3>
  <ul id="cartItems" class="list-group mb-3">
    <!-- Cart items will be appended here dynamically -->
  </ul>
  <p class="fw-bold">Total Harga: Rp <span id="totalPrice">0</span></p>
  
  <!-- Button Bayar -->
  <button class="btn btn-success w-100 mt-3" onclick="redirectToCheckout()">Bayar</button>
</div>

<!-- Modal -->
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

  function showModal(itemName, itemPrice) {
    selectedItem = { name: itemName, price: itemPrice };
    document.getElementById('menuModalLabel').textContent = itemName;
    document.getElementById('quantity').value = 1;
    new bootstrap.Modal(document.getElementById('menuModal')).show();
  }

  function addToCart() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const item = { ...selectedItem, quantity };
    cart.push(item);
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
        ${item.name} x ${item.quantity} 
        <span>
          Rp ${itemTotal} 
          <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${index})">Hapus</button>
        </span>
      `;
      cartItemsContainer.appendChild(listItem);
    });

    document.getElementById('totalPrice').textContent = totalPrice;
  }

  function redirectToCheckout() {
    const totalPrice = document.getElementById('totalPrice').textContent;
    window.location.href = `/checkout?total_price=${totalPrice}`;
  }
</script>

</body>
</html>
