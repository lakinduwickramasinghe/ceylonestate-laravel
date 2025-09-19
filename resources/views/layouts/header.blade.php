<!-- Header -->
<header class="fixed top-0 left-0 right-0 bg-white shadow z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 h-16">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img class="w-10 h-10 rounded" src="{{ asset('images/logo.png') }}" alt="Logo">
            <span class="text-xl font-bold text-[#1b5d38]">CEYLON ESTATE</span>
        </a>

        <!-- Navigation Links -->
        <nav class="hidden md:flex space-x-6 text-gray-700 font-medium">
            <a href="{{ url('/') }}" class="hover:text-[#1b5d38]">Home</a>
            <a href="{{ route('properties') }}" class="hover:text-[#1b5d38]">Properties</a>
            <a href="{{ route('aboutus') }}" class="hover:text-gray-400">About Us</a>
        </nav>

        <!-- User Section -->
        <div class="flex items-center space-x-4">
            @auth
                <!-- Logged-in User: Dashboard Button Only -->
                <a href="{{ route('dashboard') }}" class="bg-[#1b5d38] hover:bg-green-700 text-white px-4 py-1 rounded-md font-medium transition">Dashboard</a>
            @else
                <!-- Guest: Login & Register Buttons -->
                <div class="flex space-x-3">
                    <a href="{{ route('login') }}" class="bg-white border border-[#1b5d38] text-[#1b5d38] px-4 py-1 rounded-md font-medium hover:bg-[#1b5d38] hover:text-white transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-[#1b5d38] hover:bg-green-700 text-white px-4 py-1 rounded-md font-medium transition">Register</a>
                </div>
            @endauth
        </div>
    </div>
</header>