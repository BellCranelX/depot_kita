<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-10 rounded-lg shadow-lg text-center max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-green-600 mb-4">Transaction Completed!</h1>
        
        @if(session('success'))
            <p class="text-gray-700 mb-6">{{ session('success') }}</p>
        @endif
        
        <a href="{{ route('customer.order') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Back to Home</a>
    </div>

</body>
</html>
