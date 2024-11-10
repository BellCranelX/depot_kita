<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Navbar with Sidebar</title>
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])


    <script src="{{ asset('assets/jquery.js') }}"></script>
    <link href={{asset("DataTables/datatables.min.css")}} rel="stylesheet">


    <link rel="stylesheet" href="{{asset("fontawesome-free-6.6.0-web\css\all.min.css")}}">
    {{-- For Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poltawski+Nowy:ital,wght@0,400..700;1,400..700&display=swap"

        rel="stylesheet">
    <style>
        body {
            font-family: 'Poltawski Nowy', serif;
            background-color: #FCF1D5;
        }
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
    <!-- Main Top Navbar -->
    <nav class="bg-[#20252f] text-white p-4 fixed top-0 left-0 right-0 z-10">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo Section -->
            <div class="flex items-center">
                <button id="sidebarOpen" class="text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <a href="{{route('admin.dashboard')}}" class="flex items-center ml-4">
                    <img src="{{ asset('logo/depot_kita.jpg') }}" alt="Logo" class="h-14 w-13 mr-5">
                    <span class="font-bold text-xl">Depot Kita</span>
                </a>
            </div>

            <!-- Navbar Links (Right) -->
            <!-- Navbar Buttons with Dropdown -->
            <div class="relative flex space-x-8 items-center mr-4">

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="dropdownButton"
                        class="flex items-center space-x-2 bg-[#20252f] hover:bg-[#ae0001] text-[#f6f1e3] p-2 transition duration-300 focus:outline-none rounded">
                        @if (isset($user))
                        <img src="{{asset('asset/'.$user->photo)}}" alt="Profile Icon"
                            class="h-8 w-8 rounded-full bg-[#f6f1e3]">
                        @else
                        <img src="../../../asset/profile-circle.256x256.png" alt="Profile Icon"
                            class="h-8 w-8 rounded-full bg-[#f6f1e3]">
                        @endif

                        <span>
                            @if (isset($user) && $user->role === 'admin')
                            {{ $user->name }} (Admin)
                            @else
                            Employee
                            @endif
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu"
                        class="hidden absolute right-0 top-full w-full bg-[#20252f] text-[#f6f1e3] shadow-lg mt-1">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm hover:bg-[#ae0001] transition duration-300">Profile</a>
                        <a href="{{ route('logout') }}"
                            class="block px-4 py-2 text-sm hover:bg-[#ae0001] transition duration-300">Logout</a>
                    </div>
                </div>
            </div>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed left-0 top-0 w-72 h-full bg-[#20252f] text-white p-8 z-20 transform -translate-x-full transition-transform duration-300 overflow-y-auto no-scrollbar">
        <div class="flex justify-between items-center mb-8">
            <button id="sidebarClose" class="text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <ul class="space-y-8">
            <li>
                <a href="{{ route('admin.dashboard')}}" class="flex text-[#f6f1e3] items-center hover:text-[#ae0001]">
                    <img src="../../../asset/dashboard.png" alt="Dashboard Icon" class="h-6 w-6 mr-4">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{route('products.index')}}" class="flex items-center text-[#f6f1e3]  hover:text-[#ae0001]">
                    <img src="../../../asset/evaluasi.png" alt="Evaluasi Icon" class="h-6 w-6 mr-4">
                    Menus
                </a>
            </li>
            <li>
                <a href="{{route('transactions.index')}}" class="flex items-center text-[#f6f1e3]  hover:text-[#ae0001]">
                    <img src="../../../asset/evaluasi.png" alt="Evaluasi Icon" class="h-6 w-6 mr-4">
                    Transactions
                </a>
            </li>
            <li>
                <a href="{{ route('orders.index')}}" class="flex items-center text-[#f6f1e3]  hover:text-[#ae0001]">
                    <img src="../../../asset/announcement.png" alt="Acara Icon" class="h-6 w-6 mr-4">
                    Orders
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center text-[#f6f1e3]  hover:text-[#ae0001]">
                    <img src="../../../asset/evaluasi.png" alt="Evaluasi Icon" class="h-6 w-6 mr-4">
                    Evaluasi
                </a>
            </li>
        </ul>
    </div>


    <!-- Dark Overlay (when sidebar is open) -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden z-10"></div>

    @yield('content')

    @vite('resources/js/app.js')
    @yield('libraryjs')

    <!-- JavaScript to control sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOpen = document.getElementById('sidebarOpen');
        const sidebarClose = document.getElementById('sidebarClose');
        const overlay = document.getElementById('overlay');

        // Open Sidebar
        sidebarOpen.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        // Close Sidebar
        sidebarClose.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Close Sidebar when clicking outside (on overlay)
        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Toggle dropdown visibility
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Hide dropdown when clicked outside
        document.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        //dropdown list jadwal
        const jadwalButton = document.getElementById('jadwalButton');
        const jadwalDropdown = document.getElementById('jadwalDropdown');

        jadwalButton.addEventListener('click', () => {
            jadwalDropdown.classList.toggle('hidden');
            jadwalButton.querySelector('svg').classList.toggle('rotate-180'); // Rotate arrow icon
        });

        //dropdown input
        const inputButton = document.getElementById('inputButton');
        const inputDropdown = document.getElementById('inputDropdown');

        inputButton.addEventListener('click', () => {
            inputDropdown.classList.toggle('hidden');
            inputButton.querySelector('svg').classList.toggle('rotate-180'); // Rotate arrow icon
        });

        //dropdown pengurus
        const pengurusButton = document.getElementById('pengurusButton');
        const pengurusDropdown = document.getElementById('pengurusDropdown');

        pengurusButton.addEventListener('click', () => {
            pengurusDropdown.classList.toggle('hidden');
            pengurusButton.querySelector('svg').classList.toggle('rotate-180'); // Rotate arrow icon
        });
    </script>

</body>

</html>