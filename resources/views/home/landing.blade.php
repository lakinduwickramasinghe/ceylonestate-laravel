<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ceylon Estate - Home</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>
<body class="bg-gray-50 font-sans">

    @include('layouts.header')

    <!-- Hero Section -->
    <section class="h-[600px] flex items-center" 
            style="background-image: url('{{ asset('./images/hero1.jpeg') }}'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-6 text-white text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Find Your Dream Property</h1>
            <p class="text-lg md:text-2xl mb-6 drop-shadow-md">Explore the best properties for sale across Sri Lanka.</p>
            <div class="flex justify-center">
                <a href="{{ route('properties') }}" class="bg-lime-400 hover:bg-lime-500 text-gray-900 px-6 py-3 rounded-md font-semibold transition">
                    Browse Properties
                </a>
            </div>
        </div>
    </section>

    <!-- Properties Section -->
    <section id="properties" class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center">Featured Properties</h2>
            
            <!-- Properties Grid -->
            <div id="properties-grid" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Properties will be injected here by JS -->
            </div>

        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contact" class="py-20 relative" 
            style="background-image: url('{{ asset('./images/hero4.jpg') }}'); background-size: cover; background-position: center;">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
        <div class="relative max-w-3xl mx-auto px-6 text-center text-white">
            <h2 class="text-4xl font-bold mb-3">Get in Touch with Us</h2>
            <p class="text-lg mb-10">Need to talk? We’re here to answer your questions and help you find the right property.</p>
            
            <form action="" method="POST" 
                class="bg-white bg-opacity-90 shadow-md rounded-lg p-8 space-y-4 text-left">
                @csrf
                <div>
                    <label for="name" class="block text-gray-800 font-medium mb-1">Name</label>
                    <input type="text" name="name" id="name" required 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-[#1b5d38] focus:ring-1 focus:ring-[#1b5d38]">
                </div>
                <div>
                    <label for="email" class="block text-gray-800 font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" required 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-[#1b5d38] focus:ring-1 focus:ring-[#1b5d38]">
                </div>
                <div>
                    <label for="message" class="block text-gray-800 font-medium mb-1">Message</label>
                    <textarea name="message" id="message" rows="5" required 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-[#1b5d38] focus:ring-1 focus:ring-[#1b5d38]"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-[#1b5d38] hover:bg-green-700 text-white px-6 py-2 rounded-md font-semibold transition">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </section>

    @include('layouts.footer')

    <!-- Axios Script to fetch properties -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.getElementById('properties-grid');

        axios.get('/api/property',{
            headers: {
            Authorization: `Bearer {{ session('auth_token') }}`}
        })
            .then(res => {
                const properties = res.data.data;
                properties.forEach(property => {
                    // Pick main image or first image
                    let mainImage = property.images.find(img => img.is_main) || property.images[0];
                    let imagePath = mainImage ? `/property_images/${mainImage.imagepath.split('/').pop()}` : '/images/default-property.jpg';

const card = document.createElement('div');
card.className = 'bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition flex flex-col';
card.innerHTML = `
    <img src="${imagePath}" alt="${property.title}" class="w-full h-48 object-cover">
    <div class="p-4 flex flex-col flex-grow">
        <h3 class="text-xl font-semibold mb-2">${property.title}</h3>
        <p class="text-gray-600 mb-3">${property.address_line_1}, ${property.city}</p>
        <p class="text-green-600 font-bold mb-4">LKR ${parseFloat(property.price).toLocaleString()}</p>
        <div class="mt-auto">
            <a href="/properties/${property.id}" 
               class="block w-full text-center bg-[#1b5d38] hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition">
               View Details
            </a>
        </div>
    </div>
`;

                    grid.appendChild(card);
                });
            })
            .catch(err => {
                console.error('Failed to fetch properties', err);
                grid.innerHTML = '<p class="text-center col-span-3 text-gray-500">No properties found.</p>';
            });
    });
    </script>

</body>
</html>
