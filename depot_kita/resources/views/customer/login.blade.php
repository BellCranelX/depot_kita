<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.2/tailwind.min.css">
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">
        <img class="mx-auto w-1/3 mb-6" src="{{asset('logo/depot_kita.jpg')}}" alt="depot_kita Logo">
        <form action="{{ route('customer.login') }}" method="POST">
            @csrf
            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required autofocus>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600">
                Login
            </button>

        </form>

        <!-- Register Link -->
        <div class="mt-4 text-center">
            <p class="text-gray-600">Doesn't have an account? <a href="{{ route('customer.register') }}" class="text-blue-500 hover:text-blue-700">Register here</a></p>
        </div>
        
    </div>
</body>

</html>
