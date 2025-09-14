<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ceylon Estate Homepage</title>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

<!-- Hero Section -->
<section class="py-12 sm:py-16 text-center relative">
    <div class="absolute inset-0 z-0" style="background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black opacity-40"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-3xl sm:text-4xl font-bold mb-4 text-white">FIND YOUR DREAM HOME</h1>
        <p class="text-base sm:text-lg mb-6 sm:mb-8 text-white">Now you can save yourself the stress, time, and hidden costs, with hundreds of homes for you to choose from.</p>
        <div class="max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <div class="relative rounded-lg overflow-hidden shadow-lg group">
                <div class="absolute inset-0 z-0" style="background-size: cover; background-position: center;">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1A5C38]/80 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                </div>
                <div class="relative z-10 p-4 sm:p-6 flex flex-col items-center justify-center h-40 sm:h-48">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-4">Buy Your Dream Home</h3>
                    <a href="{{ url('forsale') }}" class="white-button">Explore For Sale</a>
                </div>
            </div>
            <div class="relative rounded-lg overflow-hidden shadow-lg group">
                <div class="absolute inset-0 z-0" style="background-size: cover; background-position: center;">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1A5C38]/80 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                </div>
                <div class="relative z-10 p-4 sm:p-6 flex flex-col items-center justify-center h-40 sm:h-48">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-4">Rent Your Perfect Space</h3>
                    <a href="{{ url('forrent') }}" class="white-button">Explore For Rent</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Properties For Sale -->
<section class="py-12 sm:py-16">
    <div class="container mx-auto px-4 max-w-6xl">
        <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-center text-[#1A5C38]">Properties For Sale</h2>
        <div id="forsale" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"></div>
    </div>
</section>

<!-- Properties For Rent -->
<section class="py-12 sm:py-16">
    <div class="container mx-auto px-4 max-w-6xl">
        <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-center text-[#1A5C38]">Properties For Rent</h2>
        <div id="forrent" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"></div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 sm:py-20 relative overflow-hidden">
    <div class="absolute inset-0 z-0" style="background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 items-center">
            <div class="text-white text-center lg:text-left animate-fade-in" style="animation-delay: 0.2s;">
                <h3 class="text-3xl sm:text-4xl font-extrabold mb-6 sm:mb-8 drop-shadow-lg">Need to Talk?</h3>
                <p class="text-xl sm:text-2xl mb-4 sm:mb-6 drop-shadow">We’re Here to Help You</p>
                <div class="space-y-3 sm:space-y-4">
                    <p class="text-base sm:text-lg">Contact Us:</p>
                    <p class="text-base sm:text-lg">No 645, 9 Kings Street, Matale, Sri Lanka</p>
                    <p class="text-base sm:text-lg">Phone: <a href="tel:+94645923215" class="underline hover:text-gray-300">645 923 215</a></p>
                    <p class="text-base sm:text-lg">Email: <a href="mailto:help@ceylonestate.lk" class="underline hover:text-gray-300">help@ceylonestate.lk</a></p>
                    <p class="text-base sm:text-lg mt-4 sm:mt-6">Social Media:</p>
                    <p class="text-base sm:text-lg">ceylonestate.matale</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white/80 backdrop-blur-md p-6 sm:p-8 rounded-xl shadow-xl w-full max-w-md mx-auto lg:mx-0 animate-fade-in" style="animation-delay: 0.4s;">
                <h3 class="text-xl sm:text-2xl font-bold text-[#1A5C38] mb-4 sm:mb-6">Got a Question?</h3>
                <form action="" method="POST" class="space-y-4 sm:space-y-6">
                    <div class="relative mb-4 sm:mb-6">
                        <input type="email" name="email" placeholder="Your email..." required class="w-full p-3 sm:p-4 pl-10 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A5C38] placeholder-gray-500 transition-all duration-300 text-sm sm:text-base">
                    </div>
                    <div class="relative mb-4 sm:mb-6">
                        <textarea name="question" placeholder="Your question..." required class="w-full p-3 sm:p-4 pt-8 sm:pt-10 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A5C38] h-32 sm:h-40 placeholder-gray-500 transition-all duration-300 text-sm sm:text-base"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#1A5C38] text-white py-2 sm:py-3 rounded-lg hover:bg-[#154c2f] transition-all duration-300 font-semibold shadow-md text-sm sm:text-base">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    axios.get('/api/property')
        .then(function (response) {
            const properties = Array.isArray(response.data) ? response.data : (response.data.data || []);
            const saleContainer = document.getElementById('forsale');
            const rentContainer = document.getElementById('forrent');

            properties.forEach(listing => {
                const imageBase64 = listing.image_base64 || '';
                
                // Determine property details based on type
                let detailsHTML = '';
                switch(listing.property_type) {
                    case 'residential':
                        detailsHTML = `
                            <span class="flex items-center">Bedrooms: ${listing.residential?.bedrooms || 0}</span>
                            <span class="flex items-center">Bathrooms: ${listing.residential?.bathrooms || 0}</span>
                            <span class="flex items-center">Area: ${listing.residential?.floor_area || 0} m²</span>
                            <span class="flex items-center">Floors: ${listing.residential?.floors || 0}</span>
                        `;
                        break;
                    case 'commercial':
                        detailsHTML = `
                            <span class="flex items-center">Floor Area: ${listing.commercial?.floor_area || 0} m²</span>
                            <span class="flex items-center">Parking: ${listing.commercial?.parking_spaces || 0}</span>
                            <span class="flex items-center">Business Type: ${listing.commercial?.business_type || '-'}</span>
                            <span class="flex items-center">Floors: ${listing.commercial?.number_of_floors || 0}</span>
                        `;
                        break;
                    case 'industrial':
                        detailsHTML = `
                            <span class="flex items-center">Power Capacity: ${listing.industrial?.power_capacity || 0} kW</span>
                            <span class="flex items-center">Floor Load: ${listing.industrial?.floor_load_capacity || 0} kg/m²</span>
                            <span class="flex items-center">Crane: ${listing.industrial?.crane_availability || 'No'}</span>
                        `;
                        break;
                    case 'land':
                        detailsHTML = `
                            <span class="flex items-center">Land Size: ${listing.land?.land_size || 0} m²</span>
                            <span class="flex items-center">Road Frontage: ${listing.land?.road_frontage || 0} m</span>
                            <span class="flex items-center">Soil Type: ${listing.land?.soil_type || '-'}</span>
                        `;
                        break;
                    case 'rental':
                        detailsHTML = `
                            <span class="flex items-center">Frequency: ${listing.rental?.rent_frequency || '-'}</span>
                            <span class="flex items-center">Lease Term: ${listing.rental?.lease_term || '-'}</span>
                            <span class="flex items-center">Furnished: ${listing.rental?.furnished || '-'}</span>
                            <span class="flex items-center">Available From: ${listing.rental?.available_from || '-'}</span>
                        `;
                        break;
                    default:
                        detailsHTML = '';
                }

                const card = `
                    <a href="/viewlisting/load/${listing.id}" class="block">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden h-80 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                            <div class="relative w-full h-40">
                                ${imageBase64 ? `<img src="data:image/jpeg;base64,${imageBase64}" alt="Property" class="w-full h-full object-cover rounded-t-xl">` : ''}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent rounded-t-xl"></div>
                                <span class="absolute top-2 left-2 bg-[#1A5C38] text-white text-xs font-semibold px-2 py-1 rounded-full">
                                    ${listing.listing_type === 'Selling' ? 'For Sale' : 'For Rent'}
                                </span>
                            </div>
                            <div class="p-4">
                                <h4 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-1">${listing.title}</h4>
                                <p class="text-xl font-bold text-red-600 mb-2">Rs.${listing.price.toLocaleString()}${listing.listing_type === 'Renting' ? '/month' : ''}</p>
                                <p class="text-gray-700 text-base line-clamp-1">${listing.address_line_1}</p>
                                <div class="flex flex-wrap gap-3 mt-3 text-sm text-gray-600">
                                    ${detailsHTML}
                                </div>
                            </div>
                        </div>
                    </a>
                `;

                if(listing.listing_type === 'Selling') saleContainer.insertAdjacentHTML('beforeend', card);
                else rentContainer.insertAdjacentHTML('beforeend', card);
            });
        })
        .catch(function (error) {
            console.error('Error loading properties:', error);
        });
});
</script>

</body>
</html>
