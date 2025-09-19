<!-- Footer -->
<footer class="bg-black text-white py-6">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
        
        <!-- Logo -->
        <div class="flex items-center space-x-2 mb-4 md:mb-0">
            <img class="w-8 h-8 rounded" src="{{ asset('images/logo.png') }}" alt="Logo">
            <span class="text-lg font-bold">CEYLON ESTATE</span>
        </div>

        <!-- Navigation Links -->
        <nav class="flex space-x-4 text-sm font-medium mb-4 md:mb-0">
            <a href="{{ url('/') }}" class="hover:text-gray-400">Home</a>
            <a href="{{route('properties')}}" class="hover:text-gray-400">Properties</a>
            <a href="{{route('aboutus')}}" class="hover:text-gray-400">About Us</a>
        </nav>

        <!-- Copyright -->
        <div class="text-xs text-gray-400">
            © {{ date('Y') }} Ceylon Estate. All rights reserved.
        </div>
    </div>
</footer>