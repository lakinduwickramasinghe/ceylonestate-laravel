<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','Admin Panel - Ceylon Estate')</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
/* Overlapping avatars */
.overlap-avatars > img { margin-left: -0.5rem; }
.overlap-avatars > .count { margin-left: -0.5rem; }
/* Theme switch */
.theme-switch { position: relative; width: 48px; height: 24px; border-radius: 9999px; cursor: pointer; background-color: #e2e8f0; padding: 2px; display: flex; align-items: center; justify-content: space-between; }
.theme-switch input { display: none; }
.theme-switch .knob { position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 9999px; transition: transform 0.3s; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #fbbf24; }
.theme-switch.active .knob { transform: translateX(24px); color: #4b5563; }
/* Dark mode */
.dark-mode { background-color: #1a202c; color: #e2e8f0; }
.dark-mode .bg-white { background-color: #2d3748; }
.dark-mode .border-gray-200 { border-color: #4a5568; }
.dark-mode .text-gray-700 { color: #a0aec0; }
.dark-mode .text-gray-600 { color: #cbd5e0; }
.dark-mode .text-gray-500 { color: #718096; }
.dark-mode .bg-gray-50 { background-color: #2d3748; }
/* Sub-nav transition */
.sub-nav { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-in-out; }
.sub-nav.show { max-height: 1000px; }
</style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

<!-- Header -->
<header class="fixed top-0 left-0 right-0 h-16 bg-white flex items-center px-5 shadow z-50">
    <a href="{{ url('/') }}" class="all-[unset]">
    <div class="flex items-center space-x-3">
        
            <img class="w-10 h-10 rounded" src="{{ asset('images/logo.png') }}" alt="Logo">
            <span class="text-xl font-bold text-[#1b5d38]">CEYLON ESTATE</span>
        
    </div>
    </a>

    <div class="flex-1 ml-10 text-gray-600 text-sm">
        <nav class="flex space-x-2">
            <span>Home</span>
            <i class="fas fa-chevron-right text-xs self-center"></i>
            <span>Properties</span>
            <i class="fas fa-chevron-right text-xs self-center"></i>
            <span>Leads</span>
        </nav>
    </div>

    <input type="text" placeholder="Search properties..." class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700 focus:outline-none focus:border-[#1b5d38] focus:ring-1 focus:ring-[#1b5d38] w-64">

    <div class="flex items-center space-x-4 ml-4">
        <span class="text-gray-500 text-lg cursor-pointer hover:text-gray-700"><i class="fas fa-gear"></i></span>
        <div class="relative">
            <span class="text-gray-500 text-lg cursor-pointer hover:text-gray-700"><i class="fas fa-bell"></i></span>
            <div class="absolute -top-1 -right-1 bg-green-500 text-white rounded-full w-4 h-4 text-[10px] flex items-center justify-center font-medium">2</div>
        </div>
        <!-- Theme Toggle with Icons -->
        <label class="theme-switch" id="theme-switch">
            <input type="checkbox">
            <div class="knob flex items-center justify-center">
                <i class="fas fa-sun"></i>
            </div>
            <i class="fas fa-sun text-yellow-400 ml-1"></i>
            <i class="fas fa-moon text-gray-500 mr-1"></i>
        </label>
        
        @if(Auth::user()->profile_photo_path)
            <img class="w-8 h-8 rounded-full cursor-pointer object-cover" 
                src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                alt="User">
        @else
            <img class="w-8 h-8 rounded-full cursor-pointer object-cover" 
                src="{{ Auth::user()->profile_photo_url }}" 
                alt="User">
        @endif



    </div>
</header>

<!-- Side Nav -->
<nav class="fixed left-0 top-16 w-56 h-[calc(100vh-64px)] bg-white border-r border-gray-200 overflow-y-auto z-40 shadow-sm">
    <div class="flex flex-col flex-1">

        <!-- Dashboard -->
        <a href="{{ route('member-db') }}">
            <div class="sidebar-item px-5 py-3 flex items-center text-gray-700 cursor-pointer border-b border-gray-100">
                <i class="fas fa-tachometer-alt text-gray-500 mr-3"></i> Dashboard
            </div>  
        </a>

        <!-- My Property Ads -->
        <a href="{{ route('property.index') }}">
            <div class="sidebar-item px-5 py-3 flex items-center text-gray-700 cursor-pointer border-b border-gray-100">
                <i class="fas fa-building text-gray-500 mr-3"></i> My Property Ads
            </div>  
        </a>

        <!-- My Reviews -->
        <a href="">
            <div class="sidebar-item px-5 py-3 flex items-center text-gray-700 cursor-pointer border-b border-gray-100">
                <i class="fas fa-star text-gray-500 mr-3"></i> My Reviews
            </div>  
        </a>

        <!-- Chat -->
        <a href="">
            <div class="sidebar-item px-5 py-3 flex items-center text-gray-700 cursor-pointer border-b border-gray-100">
                <i class="fas fa-comments text-gray-500 mr-3"></i> Chat
            </div>  
        </a>

        <!-- My Payments -->
        <a href="">
            <div class="sidebar-item px-5 py-3 flex items-center text-gray-700 cursor-pointer border-b border-gray-100">
                <i class="fas fa-credit-card text-gray-500 mr-3"></i> My Payments
            </div>  
        </a>

        <!-- Logout -->
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="mt-auto px-5 py-3 flex items-center text-red-600 hover:bg-red-100 cursor-pointer border-t border-red-300">
            <i class="fas fa-sign-out-alt text-red-600 mr-3"></i>
            <span class="font-medium">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</nav>


<!-- Main Content -->
<main class="ml-56 mt-16 p-6 bg-gray-50 min-h-[calc(100vh-64px)]">
    @yield('content')
</main>

<script>
// Toggle sub-nav
document.querySelectorAll('.sidebar-item.flex-col > .flex').forEach(item => {
    item.addEventListener('click', () => {
        const subNav = item.parentElement.querySelector('.sub-nav');
        const chevron = item.querySelector('i.fas.fa-chevron-down');
        if(subNav){
            subNav.classList.toggle('show');
            chevron.classList.toggle('rotate-180');
        }
    });
});

// Theme switch with icons
const themeSwitch = document.getElementById('theme-switch');
const input = themeSwitch.querySelector('input');
const knob = themeSwitch.querySelector('.knob');
input.addEventListener('change', () => {
    document.body.classList.toggle('dark-mode');
    themeSwitch.classList.toggle('active');
    knob.innerHTML = input.checked ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
});
</script>
</body>
</html>
