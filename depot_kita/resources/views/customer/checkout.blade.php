<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    .qr-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 50px;
    }
    .qr-container img {
      max-width: 300px;
      width: 100%;
      height: auto;
    }
    .qr-container h3 {
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="qr-container">
    <h3>Scan QR Code untuk Melakukan Pembayaran</h3>
    <img src="{{ asset('asset/qrcode.png') }}" alt="QR Code Pembayaran">
    
    <!-- Menampilkan total harga -->
    <p class="fw-bold mt-3">Total Harga: Rp {{ number_format($total_price, 0, ',', '.') }}</p>
    
    <p class="mt-2">Gunakan aplikasi pembayaran yang mendukung QR Code untuk menyelesaikan transaksi Anda.</p>

    <!-- Tombol menuju halaman nomor antrian -->
    <a href="/queue" class="btn btn-primary mt-4">Lihat Nomor Antrian</a>
  </div>
</div>

</body>
</html>
