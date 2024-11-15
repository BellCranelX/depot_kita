<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">


  <div class="max-w-3xl mx-auto py-10 px-6 bg-white shadow-lg rounded-lg mt-10">
    <h1 class="text-2xl font-bold text-center mb-8">Checkout</h1>


    <!-- Products List -->
    <!-- Pending Transactions -->
    <!-- Pending Transactions -->
    <!-- Pending Transactions -->
    <h2 class="text-xl font-semibold mb-4">Pending Transactions</h2>
    <ul class="bg-gray-50 p-4 rounded-lg mb-6">
      @foreach ($transactions as $transaction)
      <li class="mb-4 p-4 bg-white rounded-lg shadow-sm border">
        <p><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
        <p><strong>Amount:</strong> {{ number_format($transaction->amount, 2) }} IDR</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($transaction->payment_method) }}</p>

        <!-- Display ordered products for this transaction -->
        <h3 class="text-lg font-semibold mt-2">Ordered Products:</h3>
        <ul class="bg-gray-100 p-2 rounded-lg">
          @foreach ($transaction->order->orderProducts as $orderProduct)
          @if($orderProduct->product) <!-- Check if product exists -->
          <li class="flex items-center p-2 border-b border-gray-200 last:border-b-0">
            <img src="{{ asset('menu/' . $orderProduct->product->image_url) }}" alt="{{ $orderProduct->product->name }}" class="w-20 h-20 mr-4 rounded">
            <div class="flex-grow">
              <span class="font-medium">{{ $orderProduct->product->name }}</span>
              <span class="text-sm text-gray-500">x {{ $orderProduct->quantity }}</span>
            </div>
            <span class="font-semibold">{{ number_format($orderProduct->price, 2) }} IDR</span>
          </li>
          @else
          <li class="flex justify-between items-center p-2 border-b border-gray-200 last:border-b-0">
            <span class="text-red-500">Product not found</span>
          </li>
          @endif
          @endforeach
        </ul>

        <button class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded pay-button" data-snap-token="{{ $transaction->snap_token }}">
          Pay {{ ucfirst($transaction->payment_method) }}
        </button>
      </li>
      @endforeach
    </ul>
  </div>

  <!-- Midtrans Snap.js Library -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
  <script type="text/javascript">
    document.querySelectorAll('.pay-button').forEach(button => {
      button.onclick = function() {
        const snapToken = button.getAttribute('data-snap-token');

        // Initiate payment
        snap.pay(snapToken, {
          onSuccess: function(result) {
            // Send AJAX request to update transaction status
            fetch("{{ route('payment.success') }}", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                  token: snapToken
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  // Redirect to the order success page
                  console.log("Transaction completed, redirecting to success page.");
                  window.location.href = "{{ route('order.success') }}";
                } else {
                  document.getElementById('result-json').innerHTML += JSON.stringify(data.message, null, 2);
                }
              })
              .catch(error => {
                console.error('Error updating transaction status:', error);
                document.getElementById('result-json').innerHTML += JSON.stringify(error, null, 2);
              });
          },
          onPending: function(result) {
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          onError: function(result) {
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          }
        });
      };
    });
  </script>


</body>

</html>