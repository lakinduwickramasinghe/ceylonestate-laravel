@extends('layouts.admin')

@section('title','View Property - Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Loading State -->
    <div id="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[#1b5d38]"></div>
    </div>

    <!-- Error Message -->
    <div id="error-message" class="hidden bg-red-100 text-red-700 p-4 rounded-lg mb-8 text-center"></div>

    <!-- Property Hero Section -->
    <div id="property-hero" class="hidden relative bg-gray-200 rounded-lg overflow-hidden mb-8">
        <div id="hero-image" class="w-full h-96 bg-cover bg-center" style="background-image: url('/images/default-property.jpg')"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="absolute bottom-0 p-6 w-full">
            <h1 id="property-title" class="text-3xl sm:text-4xl font-bold text-white mb-2"></h1>
            <div class="flex items-center justify-between">
                <p id="property-price" class="text-2xl font-semibold text-green-400"></p>
                <span id="property-status" class="px-4 py-1 bg-[#1b5d38] text-white rounded-full text-sm font-medium"></span>
            </div>
        </div>
    </div>

    <!-- Main Content and Sidebar -->
    <div id="property-content" class="hidden grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Image Gallery -->
            <div id="property-images" class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-[#1b5d38] mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M3 3h18v18H3zm16 2H5v14h14zM7 7h4v4H7zm6 0h4v4h-4z"/>
                    </svg>
                    Gallery
                    <span id="image-count" class="ml-2 text-sm text-gray-500"></span>
                </h2>
                <div id="image-gallery" class="relative overflow-hidden">
                    <div id="main-image-container" class="w-full h-64 bg-cover bg-center mb-4 rounded-lg" style="background-image: url('/images/default-property.jpg')"></div>
                    <div id="thumbnail-gallery" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2"></div>
                </div>
                <p id="no-images" class="hidden text-gray-500 italic">No images available for this property.</p>
            </div>

            <!-- Description -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-[#1b5d38] mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4 21h16v-2H4v2zm0-6h16v-2H4v2zm0-6h16V7H4v2z"/>
                    </svg>
                    Description
                </h2>
                <p id="property-description" class="text-gray-600"></p>
            </div>

            <!-- Property Details -->
            <div id="property-details" class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-[#1b5d38] mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 2L2 7v6c0 5 4 9 10 9s10-4 10-9V7z"/>
                    </svg>
                    Property Details
                </h2>
                <div id="specific-details" class="grid grid-cols-1 sm:grid-cols-2 gap-4"></div>
                <p id="no-details" class="hidden text-gray-500 italic col-span-full">No specific details available.</p>
            </div>

            <!-- Map and Address -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-[#1b5d38] mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Location
                </h2>
                <div id="map" class="w-full h-80 rounded-lg border border-gray-200 mb-4"></div>
                <div id="address-details" class="text-gray-700 space-y-2"></div>
                <p id="map-coordinates" class="text-sm text-gray-500 mt-2"></p>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-span-1">
            <div class="sticky top-16 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-[#1b5d38] mb-4">Property Overview</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Price</p>
                        <p id="sidebar-price" class="text-lg font-bold text-green-600"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Posted By</p>
                        <p id="sidebar-user" class="text-gray-700"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Property Type</p>
                        <p id="sidebar-type" class="text-gray-700"></p>
                    </div>
                    <button id="delete-property" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Delete Property</button>
                    <a href="/admin/property" class="block w-full bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition text-center">Back to Properties</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google Maps API and Axios -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7Ryp7xCNU4eLnBO1SlK2sWldalQg_f3I&callback=initMap" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let map;

    function initMap() {
        const defaultPosition = { lat: 6.9271, lng: 79.8612 };
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: defaultPosition,
            mapTypeId: 'roadmap'
        });
    }

    async function fetchPropertyData() {
        const propertyId = window.location.pathname.split('/').pop();
        const loading = document.getElementById('loading');
        const errorMessage = document.getElementById('error-message');

        try {
            const response = await axios.get(`/api/properties/${propertyId}`, {
                headers: {
                    Authorization: `Bearer {{ session('auth_token') }}`
                }
            });

            const property = response.data;
            renderPropertyData(property);

            // Add delete property event listener
            document.getElementById('delete-property').addEventListener('click', () => deleteProperty(propertyId, property.title, property.user_id));
        } catch (error) {
            console.error('Error fetching property:', error);
            loading.classList.add('hidden');
            errorMessage.classList.remove('hidden');
            errorMessage.textContent = error.response?.data?.message || 'Failed to load property data.';
        }
    }

    async function deleteProperty(id, title, userId) {
        if (!confirm('Are you sure you want to delete this property?')) return;

        try {
            // Proceed with deletion
            await axios.delete(`/api/property/${id}`, {
                headers: {
                    Authorization: `Bearer {{ session('auth_token') }}`
                }
            });

            // Create a notification for the property owner
            try {
                const newNotification = {
                    user_id: userId,
                    title: `Your Property "${title}" has been deleted`,
                    content: `Your property "${title}" has been removed from the system by an administrator of the platform.`,
                    type: 'property',
                    ref: String(id)
                };
                await axios.post('/api/notification', newNotification, {
                    headers: {
                        Authorization: `Bearer {{ session('auth_token') }}`,
                        'Content-Type': 'application/json'
                    }
                });
                console.log('Notification created successfully');
            } catch (err) {
                console.error('Failed to create notification:', err.response?.data || err);
            }

            alert('Property deleted successfully.');
            window.location.href = '/admin/property';
        } catch (err) {
            console.error('Failed to delete property:', err);
            alert('Failed to delete property.');
        }
    }

    function renderPropertyData(property) {
        const loading = document.getElementById('loading');
        const propertyHero = document.getElementById('property-hero');
        const propertyContent = document.getElementById('property-content');

        // Show content
        loading.classList.add('hidden');
        propertyHero.classList.remove('hidden');
        propertyContent.classList.remove('hidden');

        // Hero Section
        document.getElementById('property-title').textContent = property.title || 'Untitled Property';
        document.getElementById('property-price').textContent = `LKR ${parseFloat(property.price || 0).toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
        document.getElementById('property-status').textContent = property.status ? property.status.charAt(0).toUpperCase() + property.status.slice(1) : 'Available';
        const mainImage = property.images?.find(image => image.is_main) || property.images?.[0];
        const heroImagePath = mainImage ? `/property_images/${mainImage.imagepath.split('/').pop()}` : '/images/default-property.jpg';
        document.getElementById('hero-image').style.backgroundImage = `url(${heroImagePath})`;

        // Image Gallery
        const galleryImages = document.getElementById('thumbnail-gallery');
        const mainImageContainer = document.getElementById('main-image-container');
        const noImages = document.getElementById('no-images');
        const imageCount = document.getElementById('image-count');

        if (property.images && property.images.length > 0) {
            // Set image count
            imageCount.textContent = `(${property.images.length} images)`;

            // Set main image
            mainImageContainer.style.backgroundImage = `url(${heroImagePath})`;

            // Render thumbnails
            galleryImages.innerHTML = property.images.map((image, index) => `
                <img src="/property_images/${image.imagepath.split('/').pop()}" 
                     alt="Property Thumbnail ${index + 1}" 
                     class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 transition ${image.is_main ? 'border-2 border-[#1b5d38]' : ''}"
                     data-index="${index}"
                     onclick="document.getElementById('main-image-container').style.backgroundImage = 'url(/property_images/${image.imagepath.split('/').pop()})'; 
                              document.querySelectorAll('#thumbnail-gallery img').forEach(img => img.classList.remove('border-2', 'border-[#1b5d38]')); 
                              this.classList.add('border-2', 'border-[#1b5d38]');">
            `).join('');
        } else {
            noImages.classList.remove('hidden');
            imageCount.textContent = '(0 images)';
        }

        // Description
        document.getElementById('property-description').textContent = property.description || 'No description available.';

        // Sidebar
        document.getElementById('sidebar-price').textContent = `LKR ${parseFloat(property.price || 0).toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
        document.getElementById('sidebar-user').textContent = property.user?.name || 'Unknown User';
        document.getElementById('sidebar-type').textContent = property.property_type ? property.property_type.charAt(0).toUpperCase() + property.property_type.slice(1) : 'Unknown';

        // Address
        const addressDetails = document.getElementById('address-details');
        addressDetails.innerHTML = `
            <p><strong>Address:</strong> ${property.address_line_1 || 'N/A'}${property.address_line_2 ? `, ${property.address_line_2}` : ''}</p>
            <p><strong>City:</strong> ${property.city || 'N/A'}</p>
            <p><strong>Province:</strong> ${property.province || 'N/A'}</p>
            ${property.postal_code ? `<p><strong>Postal Code:</strong> ${property.postal_code}</p>` : ''}
        `;

        // Map
        const mapCoordinates = document.getElementById('map-coordinates');
        if (property.latitude && property.longitude) {
            const position = { lat: parseFloat(property.latitude), lng: parseFloat(property.longitude) };
            map.setCenter(position);
            map.setZoom(15);
            new google.maps.Marker({ position, map });
        } else {
            mapCoordinates.textContent = 'Location coordinates not available.';
            mapCoordinates.classList.add('italic');
        }

        // Property Details
        const specificDetails = document.getElementById('specific-details');
        const noDetails = document.getElementById('no-details');

        if (property.property_type === 'residential' && property.residential) {
            specificDetails.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="currentColor" d="M7.814 13.163c-.049-1.127-.71-2.048-1.835-2.13Q5.556 11.002 5 11c-.556-.002-.696.013-.979.033c-1.125.082-1.786 1.003-1.835 2.13C2.101 15.118 2 19.103 2 27s.101 11.882.186 13.837c.049 1.127.71 2.048 1.835 2.13q.423.032.979.033c.556.001.696-.012.979-.033c1.125-.082 1.786-1.003 1.835-2.13c.045-1.029.094-2.62.13-5.048q.088.009.177.012C10.195 35.888 14.672 36 24 36s13.805-.111 15.88-.199q.086-.003.17-.012c.037 2.427.086 4.018.13 5.047c.05 1.127.71 2.049 1.836 2.13q.423.033.979.034q.556-.002.979-.033c1.125-.082 1.786-1.004 1.835-2.131c.064-1.488.138-4.154.17-8.827A1.997 1.997 0 0 0 43.982 30H40v.17a3 3 0 0 0-.995-.17H24c-9.328 0-13.805.112-15.88.199l-.126.007Q8 28.723 8 27c0-7.896-.101-11.882-.186-13.837"/></svg>
                    <p><strong>Bedrooms:</strong> ${property.residential.bedrooms || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7 6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5a2 2 0 0 0-2-2H8a3 3 0 0 0-3 3v5H4a2 2 0 0 0-2 2v1a6 6 0 0 0 2.625 4.961l-.332.332a1 1 0 1 0 1.414 1.414l.876-.875c.454.11.929.168 1.417.168h8c.488 0 .963-.058 1.417-.168l.876.875a1 1 0 0 0 1.414-1.414l-.332-.332A6 6 0 0 0 22 14v-1a2 2 0 0 0-2-2H7z"/></svg>
                    <p><strong>Bathrooms:</strong> ${property.residential.bathrooms || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="M10 .5h4.5v14H.5V.5h4l3 2m-1 12v-7M4 7.5h5m3 0h2.5" stroke-width="1"/></svg>
                    <p><strong>Floor Area:</strong> ${property.residential.floor_area || 'N/A'} sqft</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 8l6-3l-6-3v10"/><path d="M8 11.99l-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12m-9.51.85l11.02 6.3m0-6.3L6.5 19.15"/></svg>
                    <p><strong>Lot Size:</strong> ${property.residential.lot_size || 'N/A'} perches</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M3 22v-2h3.5v-4.5H11V11h4.5V6.5H20V3h2v5.5h-4.5V13H13v4.5H8.5V22z"/></svg>
                    <p><strong>Floors:</strong> ${property.residential.floors || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M1 1h14v14H1zm8 3H5v8h2v-2h2a3 3 0 1 0 0-6"/></svg>
                    <p><strong>Parking Spaces:</strong> ${property.residential.parking_spaces || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M13.783 15.172l2.121-2.121l5.996 5.996l-2.121 2.121zM17.5 10c1.93 0 3.5-1.57 3.5-3.5c0-.58-.16-1.12-.41-1.6l-2.7 2.7l-1.49-1.49l2.7-2.7c-.48-.25-1.02-.41-1.6-.41C15.57 3 14 4.57 14 6.5c0 .41.08.8.21 1.16l-1.85 1.85l-1.78-1.78l.71-.71l-1.41-1.41L12 3.49a3 3 0 0 0-4.24 0L4.22 7.03l1.41 1.41H2.81l-.71.71l3.54 3.54l.71-.71V9.15l1.41 1.41l.71-.71l1.78 1.78l-7.41 7.41l2.12 2.12L16.34 9.79c.36.13.75.21 1.16.21"/></svg>
                    <p><strong>Year Built:</strong> ${property.residential.year_built || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m22 10.5l-9.117-7.678a1.37 1.37 0 0 0-1.765 0L2 10.5"/><path d="M20.5 5v10.5c0 2.828 0 4.243-.879 5.121c-.878.879-2.293.879-5.121.879h-5c-2.828 0-4.243 0-5.121-.879C3.5 19.743 3.5 18.328 3.5 15.5v-6"/><path d="M10.5 11.5h-1v1h1zm4 0h-1v1h1zm-4 4h-1v1h1zm4 0h-1v1h1z"/></svg>
                    <p><strong>Balcony:</strong> ${property.residential.balcony ? 'Yes' : 'No'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M7.425 4.15q.5-.35 1.038-.088T9 4.95v.525q0 .625.45 1.063t1.075.437q.35 0 .65-.15t.5-.425q.125-.175.35-.213t.425.088q.65.425 1.125 1.013T14.4 8.55q.2.375.05.75t-.525.575t-.763.063t-.587-.513q-.125-.25-.237-.437T12.05 8.6q-.35.2-.737.288t-.788.087q-1.1 0-1.987-.612T7.25 6.724q-.95.925-1.6 2.063T5 11.25q0 .775.275 1.463t.75 1.212q.05-.5.288-.937T6.9 12.2l1.4-1.4q.275-.275.688-.275t.712.275l.95.925q.3.3.3.713t-.3.712q-.275.275-.687.288t-.713-.263l-.25-.25l-.7.7q-.125.125-.213.288T8 14.275q0 .125.025.213t.075.187q.15.35.063.7T7.8 16q-.5.5-1.175.488T5.4 16.05q-.375-.275-.7-.625t-.6-.725q-.525-.725-.812-1.612T3 11.25q0-2.425 1.3-4.112T7.425 4.15M13.5 15.9l-.5.5V21q0 .425-.288.713T12 22t-.712-.288T11 21v-2.6l-2.9 2.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7L18.9 7.7q.275-.275.7-.275t.7.275t.275.7t-.275.7L17.4 12H20q.425 0 .713.288T21 13t-.288.713T20 14h-4.6l-.5.5l1.5 1.5H20q.425 0 .713.288T21 17t-.288.713T20 18h-1.6l1.4 1.4q.275.275.275.7t-.275.7t-.7.275t-.7-.275L17 19.4V21q0 .425-.288.713T16 22t-.712-.288T15 21v-3.6z"/></svg>
                    <p><strong>Heating/Cooling:</strong> ${property.residential.heating_cooling || 'N/A'}</p>
                </div>
                ${property.residential.amenities ? `
                    <div class="col-span-full mt-4">
                        <h3 class="font-medium text-[#1b5d38] mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m22 10.5l-9.117-7.678a1.37 1.37 0 0 0-1.765 0L2 10.5"/><path d="M20.5 5v10.5c0 2.828 0 4.243-.879 5.121c-.878.879-2.293.879-5.121.879h-5c-2.828 0-4.243 0-5.121-.879C3.5 19.743 3.5 18.328 3.5 15.5v-6"/><path d="M10.5 11.5h-1v1h1zm4 0h-1v1h1zm-4 4h-1v1h1zm4 0h-1v1h1z"/></svg>
                            Amenities
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            ${JSON.parse(property.residential.amenities).map(amenity => `
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">${amenity}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
            `;
        } else if (property.property_type === 'commercial' && property.commercial) {
            specificDetails.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="M10 .5h4.5v14H.5V.5h4l3 2m-1 12v-7M4 7.5h5m3 0h2.5" stroke-width="1"/></svg>
                    <p><strong>Floor Area:</strong> ${property.commercial.floor_area || 'N/A'} sqft</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M3 22v-2h3.5v-4.5H11V11h4.5V6.5H20V3h2v5.5h-4.5V13H13v4.5H8.5V22z"/></svg>
                    <p><strong>Number of Floors:</strong> ${property.commercial.number_of_floors || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M1 1h14v14H1zm8 3H5v8h2v-2h2a3 3 0 1 0 0-6"/></svg>
                    <p><strong>Parking Spaces:</strong> ${property.commercial.parking_spaces || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M439.6 0H204.9L55.4 256h149.5l-128 256l341.3-320H247.5z"/></svg>
                    <p><strong>Power Capacity:</strong> ${property.commercial.power_capacity || 'N/A'} kW</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M320 176V16H32v480h128v-96h32v96h288V176ZM112 432H80v-32h32Zm0-80H80v-32h32Zm0-80H80v-32h32Zm0-80H80v-32h32Zm0-80H80V80h32Zm128-32h32v32h-32Zm-48 272h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32V80h32Zm80 320h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32v-32h32zm176 272H320v-32h32v-32h-32v-48h32v-32h-32v-48h32v-32h-32v-32h128Z"/></svg>
                    <p><strong>Business Type:</strong> ${property.commercial.business_type || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2M19 5l.001 9H5V5z"/></svg>
                    <p><strong>Loading Docks:</strong> ${property.commercial.loading_docks || 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M15 11.25H9a3 3 0 0 1 6 0"/><path d="M9.75 6a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M6.75.75h10.5s3 0 3 3v4.5s0 3-3 3H6.75s-3 0-3-3v-4.5s0-3 3-3M2.25 18a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M15 11.25H9a3 3 0 0 1 6 0"/><path d="M9.75 6a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M6.75.75h10.5s3 0 3 3v4.5s0 3-3 3H6.75s-3 0-3-3v-4.5s0-3 3-3M2.25 18a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M8.25 23.25a4.25 4.25 0 0 0-7.5 0M17.25 18a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M23.25 23.25a4.25 4.25 0 0 0-7.5 0m-6-5.25a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M15.75 23.25a4.25 4.25 0 0 0-7.5 0"/></svg>
                    <p><strong>Conference Rooms:</strong> ${property.commercial.conference_rooms || 'N/A'}</p>
                </div>
                ${property.commercial.accessibility_features ? `
                    <div class="col-span-full mt-4">
                        <h3 class="font-medium text-[#1b5d38] mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 2h6v2H9zM4 7h16v2H4zM2 14h20v2H2zM6 19h12v2H6z"/></svg>
                            Accessibility Features
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            ${JSON.parse(property.commercial.accessibility_features).map(feature => `
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">${feature}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
            `;
        } else if (property.property_type === 'industrial' && property.industrial) {
            specificDetails.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="M10 .5h4.5v14H.5V.5h4l3 2m-1 12v-7M4 7.5h5m3 0h2.5" stroke-width="1"/></svg>
                    <p><strong>Total Area:</strong> ${property.industrial.total_area || 'N/A'} sqft</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M439.6 0H204.9L55.4 256h149.5l-128 256l341.3-320H247.5z"/></svg>
                    <p><strong>Power Capacity:</strong> ${property.industrial.power_capacity || 'N/A'} kW</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2v20M5 12h14"/></svg>
                    <p><strong>Ceiling Height:</strong> ${property.industrial.ceiling_height || 'N/A'} m</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M4 21h16v-2H4v2zm0-6h16v-2H4v2zm0-6h16V7H4v2z"/></svg>
                    <p><strong>Floor Load Capacity:</strong> ${property.industrial.floor_load_capacity || 'N/A'} kg/m²</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M20 6V5a1 1 0 0 0-1-1H9V3H6v1H5v2h1v9H5v-2H3v2H2v2h1v4h2v-4h5v4h2v-4h1v-2h-1v-2h-2v2H9V6h8v4.62c-.47.17-.81.61-.81 1.14c0 .44.24.84.61 1.06V14h.62c.34 0 .61.28.61.62s-.27.62-.61.62c-.22 0-.42-.12-.53-.31a.62.62 0 0 0-.84-.22c-.3.16-.4.54-.23.84c.33.56.94.92 1.6.92c1.01 0 1.84-.83 1.84-1.85c0-.78-.5-1.48-1.23-1.74v-.06c.38-.22.62-.62.62-1.06c0-.46-.27-.85-.65-1.06V6zM8 13.66l-1 1v-1.42l1-1zm0-2.95l-1 1v-1.42l1-1zm-1-2V7.29l1-1v1.42z"/></svg>
                    <p><strong>Crane Availability:</strong> ${property.industrial.crane_availability ? 'Yes' : 'No'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path fill="currentColor" d="M3 1h9v2H3V1zm1 3h7v9H4V4z"/></svg>
                    <p><strong>Waste Disposal:</strong> ${property.industrial.waste_disposal || 'N/A'}</p>
                </div>
                ${property.industrial.access_roads ? `
                    <div class="col-span-full mt-4">
                        <h3 class="font-medium text-[#1b5d38] mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M3 21h18v-2H3v2zm2-4h14v-2H5v2zm2-4h10v-2H7v2z"/></svg>
                            Access Roads
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            ${JSON.parse(property.industrial.access_roads).map(road => `
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">${road}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
                ${property.industrial.safety_certifications ? `
                    <div class="col-span-full mt-4">
                        <h3 class="font-medium text-[#1b5d38] mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2L2 7v6c0 5 4 9 10 9s10-4 10-9V7z"/></svg>
                            Safety Certifications
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            ${JSON.parse(property.industrial.safety_certifications).map(cert => `
                                <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">${cert}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
            `;
        } else if (property.property_type === 'land' && property.land) {
            specificDetails.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 8l6-3l-6-3v10"/><path d="M8 11.99l-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12m-9.51.85l11.02 6.3m0-6.3L6.5 19.15"/></svg>
                    <p><strong>Land Size:</strong> ${property.land.land_size || 'N/A'} sqft</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M38.5 5.5h-29c-2.2 0-4 1.8-4 4v29c0 2.2 1.8 4 4 4h29c2.2 0 4-1.8 4-4v-29c0-2.2-1.8-4-4-4M24 42.5v-37m-12.341 0v1" stroke-width="1"/><path fill="none" stroke="currentColor" stroke-dasharray="0 0 2.059 2.059" stroke-linecap="round" stroke-linejoin="round" d="M11.659 8.559v31.912" stroke-width="1"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M11.659 41.5v1" stroke-width="1"/></svg>
                    <p><strong>Zoning:</strong> ${property.land.zoning ? property.land.zoning.charAt(0).toUpperCase() + property.land.zoning.slice(1) : 'N/A'}</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M15 15.26V13h-4l4-4h-3l3-3h-2l3-3l3 3h-2l3 3h-3l4 4h-4v2.76c2.13.71 3.68 1.91 4 3.24c-1.7-.13-3.38-.46-5-1c-1.21.61-2.63 1-4 1c-1.29 0-2.83-.42-4-1c-1.63.54-3.28.87-5 1c.54-2.23 4.4-4 9-4c1.05 0 2.06.09 3 .26M8 19s-3 1-6 1v2c3 0 6-1 6-1s2 1 4 1s4-1 4-1s3 1 6 1v-2c-3 0-6-1-6-1s-2 1-4 1s-4-1-4-1"/></svg>
                    <p><strong>Road Frontage:</strong> ${property.land.road_frontage || 'N/A'} meters</p>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M2 12h4m11 0h5M3 20.01l.01-.011M6 16.01l.01-.011M9 20.01l.01-.011M12 16.01l.01-.011M15 20.01l.01-.011M18 16.01l.01-.011M21 20.01l.01-.011M9 13s.9-3.741 3-6"/><path d="m16.186 2.241l.374 3.89c.243 2.523-1.649 4.77-4.172 5.012c-2.475.238-4.718-1.571-4.956-4.047a4.503 4.503 0 0 1 4.05-4.914l4.147-.4a.51.51 0 0 1 .557.46"/></svg>
                    <p><strong>Soil Type:</strong> ${property.land.soil_type ? property.land.soil_type.charAt(0).toUpperCase() + property.land.soil_type.slice(1) : 'N/A'}</p>
                </div>
                ${property.land.utilities ? `
                    <div class="col-span-full mt-4">
                        <h3 class="font-medium text-[#1b5d38] mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M2 5h20M3 3v2m4-2v2m10-2v2m4-2v2m-2 0l-7 7l-7-7"/></svg>
                            Utilities
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            ${JSON.parse(property.land.utilities).map(utility => `
                                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">${utility}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
            `;
        } else {
            noDetails.classList.remove('hidden');
        }
    }

    // Initialize
    window.addEventListener('load', () => {
        initMap();
        fetchPropertyData();
    });
</script>
@endsection