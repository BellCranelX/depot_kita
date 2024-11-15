<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Navbar with Sidebar</title>
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])


    <script src="{{ asset('asset/jquery.js') }}"></script>
    <link href={{asset("DataTables/datatables.min.css")}} rel="stylesheet">


    <link rel="stylesheet" href="{{asset("fontawesome-free-6.6.0-web\css\all.min.css")}}">
    {{-- For Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poltawski+Nowy:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poltawski Nowy', serif;
            background-color: #FCF1D5;
            padding-top: 64px;
        }

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

        /* Custom scrollbar */
        .description::-webkit-scrollbar {
            width: 8px;
        }

        .description::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .description::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .navbar-brand img {
            height: 70px;
            /* Adjust as needed */
            width: auto;
            margin-right: 8px;
        }

        .navbar-brand {
            font-size: 1rem;
            /* Adjust as needed */
        }
    </style>
    </style>

    @yield('librarycss')
</head>
<!-- Colors: 
        1. #740001 - merah gelap 
        2. #ae0001 - merah terang 
        3. #f6f1e3 - netral 
        4. #002366 - biru terang 
        5. #20252f - biru gelap 
    -->

<body class="bg-white">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo and Branding -->
            <a class="navbar-brand" href="{{ route('customer.order') }}">
                <img src="{{ asset('logo/depot_kita.jpg') }}" alt="Logo"> Depot Kita
            </a>

            <!-- Toggle button for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::guard('customer')->check())
                    <!-- Dropdown for logged-in user -->
                    <li class="nav-item dropdown">
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
                    <!-- Login Button for Guests -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('customer.login') }}">Login</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>



    <!-- Dark Overlay (when sidebar is open) -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden z-10"></div>

    @yield('content')

    @vite('resources/js/app.js')
    @yield('libraryjs')

    <!-- JavaScript to control sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        overlay.addEventListener('click', closeSidebar);
    </script>

</body>

</html>