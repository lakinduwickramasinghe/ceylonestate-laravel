<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Ceylon Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

    <!-- Feedbacks Section -->
    <section class="py-16 bg-gradient-to-r from-green-50 to-blue-50">
        <div class="max-w-6xl mx-auto px-6 text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">What Our Clients Say</h2>
            <p class="text-gray-600 mb-4">Real experiences from our happy clients across Sri Lanka.</p>
            <!-- Create Review Button -->
            @php
                if(Auth()->user()){
                    echo '<a href="'.route('feedback.create').'" class="bg-[#1b5d38] hover:bg-[#154526] text-white px-6 py-2 rounded-lg shadow-md transition inline-block mb-6">
                        Create Review
                    </a>';
                }
            @endphp

        </div>
        
        <div id="feedback-container" class="overflow-hidden relative max-w-6xl mx-auto px-6 pb-12">
            <div id="feedback-slider" class="flex space-x-6 transition-transform duration-1000 ease-linear">
                <!-- Feedback cards dynamically injected here -->
            </div>
        </div>
    </section>

<script>
    const slider = document.getElementById('feedback-slider');
    let scrollAmount = 0;

    function autoSlide() {
        const slideStep = 360; // card width + spacing
        scrollAmount += slideStep;
        if (scrollAmount >= slider.scrollWidth - slider.clientWidth) {
            scrollAmount = 0;
        }
        slider.style.transform = `translateX(-${scrollAmount}px)`;
    }

    setInterval(autoSlide, 3500);

    async function loadFeedbacks() {
        try {
            const feedbackRes = await axios.get('/api/feedback', {
                headers: { Authorization: `Bearer {{ session('auth_token') }}` }
            });

            const feedbacks = feedbackRes.data.data; // feedbacks from MongoDB
            const feedbackContainer = document.getElementById('feedback-slider');
            feedbackContainer.innerHTML = '';

            for (const fb of feedbacks) {
                const user = fb.user; // user from MySQL

                // Determine profile image like your snippet
                let profileImage = 'default-avatar.png';
                if (user) {
                    if (user.profile_photo_path) {
                        profileImage = `{{ asset('storage') }}/${user.profile_photo_path}`;
                    } else if (user.profile_photo_url) {
                        profileImage = user.profile_photo_url;
                    }
                }

                const stars = '★'.repeat(fb.rating) + '☆'.repeat(5 - fb.rating);

                const card = document.createElement('div');
                card.className = 'bg-white rounded-xl border-t-4 border-blue-500 shadow-lg p-6 min-w-[340px] hover:shadow-2xl transition relative flex-shrink-0';
                card.innerHTML = `
                    <svg class="absolute top-4 right-4 w-8 h-8 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 17h3V7H5v7h2v3zm9 0h3V7h-5v7h2v3z"/>
                    </svg>
                    <div class="flex items-center mb-4">
                        <img src="${profileImage}" alt="Profile" class="w-12 h-12 rounded-full mr-4 object-cover">
                        <div class="text-left">
                            <h3 class="text-lg font-semibold text-gray-900">${user ? user.first_name + ' ' + user.last_name : 'Anonymous'}</h3>
                            <div class="flex text-yellow-400">${stars}</div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">"${fb.message}"</p>
                `;
                feedbackContainer.appendChild(card);
            }

        } catch (err) {
            console.error('Error loading feedbacks:', err);
        }
    }

    loadFeedbacks();
</script>



    @include('layouts.footer');

</body>
</html>
