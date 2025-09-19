<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Ceylon Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>
<body class="bg-gray-50 font-sans">

    @include('layouts.header');

    <!-- Hero Section -->
    <section class="h-[300px] flex items-center justify-center text-white relative"
             style="background-image: url('{{ asset('./images/hero1.jpeg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <h1 class="relative text-4xl md:text-5xl font-bold">About Us</h1>
    </section>

    <!-- About Section -->
    <section class="max-w-5xl mx-auto px-6 py-16 text-center">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Who We Are</h2>
        <p class="text-gray-600 leading-relaxed text-lg">
            At <span class="font-semibold text-[#1b5d38]">Ceylon Estate</span>, we are committed to connecting people with their dream properties across Sri Lanka. 
            Whether it’s residential, commercial, land, or investment opportunities, our mission is to make the process smooth, transparent, and stress-free. 
            With a dedicated team and strong industry expertise, we strive to provide trusted property services that make a difference.
        </p>
    </section>

    <!-- Mission & Vision -->
    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10 text-center">
            <div class="bg-gray-100 p-8 rounded-lg shadow hover:shadow-md transition">
                <h3 class="text-2xl font-bold mb-4 text-[#1b5d38]">Our Mission</h3>
                <p class="text-gray-600">To simplify property buying, selling, and renting by providing reliable listings and personalized support that empower our clients to make informed decisions.</p>
            </div>
            <div class="bg-gray-100 p-8 rounded-lg shadow hover:shadow-md transition">
                <h3 class="text-2xl font-bold mb-4 text-[#1b5d38]">Our Vision</h3>
                <p class="text-gray-600">To be Sri Lanka’s most trusted real estate platform, bridging the gap between property seekers and owners with innovation and integrity.</p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
            <!-- Team Member -->
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                <img src="{{ asset('images/person1.webp') }}" alt="Team Member" class="w-32 h-32 mx-auto rounded-full mb-4 object-cover">
                <h3 class="text-xl font-semibold">Patrick Mill</h3>
                <p class="text-gray-500">Founder & CEO</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                <img src="{{ asset('images/person2.webp') }}" alt="Team Member" class="w-32 h-32 mx-auto rounded-full mb-4 object-cover">
                <h3 class="text-xl font-semibold">John Doe</h3>
                <p class="text-gray-500">Head of Operations</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                <img src="{{ asset('images/person3.jpg') }}" alt="Team Member" class="w-32 h-32 mx-auto rounded-full mb-4 object-cover">
                <h3 class="text-xl font-semibold">Jane Smith</h3>
                <p class="text-gray-500">Customer Relations Manager</p>
            </div>
        </div>
    </section>

    @include('layouts.footer');

</body>
</html>