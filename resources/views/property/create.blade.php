@extends('layouts.member')
@section('title','Create Property Ad - Admin Panel')
@section('content')

<!-- JS Panel for initial selection -->
<div id="property-type-panel" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="bg-white p-8 rounded-lg w-96 shadow-lg">
        <h2 class="text-xl font-semibold text-[#1b5d38] mb-4">Start Your Property Ad</h2>
        <p class="text-gray-600 mb-4">Select the property type to get started.</p>
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Property Type</label>
            <select id="initial-property-type" class="w-full border border-gray-300 rounded-md p-2">
                <option value="">-- Select Property Type --</option>
                <option value="residential">Residential</option>
                <option value="commercial">Commercial</option>
                <option value="industrial">Industrial</option>
                <option value="land">Land</option>
            </select>
        </div>
        <div id="property-type-description" class="text-gray-600 mb-4 italic"></div>
        <button id="start-form" class="bg-[#1b5d38] text-white px-4 py-2 rounded-md hover:bg-green-700 transition w-full">Continue</button>
    </div>
</div>

<!-- Property Form -->
<div class="max-w-5xl mx-auto py-6 hidden" id="property-form-container">
    <h1 class="text-2xl font-semibold text-[#1b5d38] mb-6 flex justify-between items-center">
        Create New Property Ad
        <button id="edit-panel" class="bg-gray-200 text-gray-700 px-2 py-1 rounded-md hover:bg-gray-300 transition text-sm">Change Selection</button>
    </h1>
    <form id="property-ad-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="property_type" id="property_type_input">
        <input type="hidden" name="status" value="available">
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <!-- Basic Info Section -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-[#1b5d38] mb-4">Basic Info</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-md p-2"></textarea>
                </div>
            </div>
        </div>

        <!-- Address Info Section -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-[#1b5d38] mb-4">Address Info</h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-1">Address Line 1</label>
                    <input type="text" name="address_line_1" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Address Line 2</label>
                    <input type="text" name="address_line_2" class="w-full border border-gray-300 rounded-md p-2">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">City</label>
                    <input type="text" name="city" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Province</label>
                    <input type="text" name="province" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Postal Code</label>
                    <input type="text" name="postal_code" class="w-full border border-gray-300 rounded-md p-2">
                </div>
            </div>

            <!-- Google Map Section -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Select Location on Map</label>
                <div id="map" class="w-full h-64 rounded-md border border-gray-300 mb-2"></div>
                <button type="button" id="current-location-btn" class="bg-[#1b5d38] text-white px-4 py-2 rounded-md hover:bg-green-700 transition mb-2">Use My Current Location</button>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>
        </div>

        <!-- Dynamic Property Type Section -->
        <div id="dynamic-fields" class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200"></div>

        <!-- Images Section -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-[#1b5d38] mb-2">Property Images</h2>
            <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full border border-gray-300 rounded-md p-2">
            <small class="text-gray-500">You can upload multiple images (jpg, png, jpeg).</small>
            <div id="image-preview" class="mt-2 grid grid-cols-4 gap-2"></div>
        </div>

        <!-- Price Section -->
        <div id="price-section" class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-[#1b5d38] mb-2">Price Info</h2>
            <div class="flex">
                <span class="px-2 flex items-center bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">LKR</span>
                <input type="number" name="price" id="price-field" class="w-full border border-gray-300 rounded-r-md p-2" placeholder="Price in LKR">
            </div>
        </div>

        <button type="submit" class="bg-[#1b5d38] text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Create Property Ad</button>
    </form>
</div>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7Ryp7xCNU4eLnBO1SlK2sWldalQg_f3I&libraries=places"></script>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
let map, marker;
function initMap() {
    const defaultLocation = { lat: 6.9271, lng: 79.8612 };
    map = new google.maps.Map(document.getElementById("map"), { center: defaultLocation, zoom: 13 });
    marker = new google.maps.Marker({ position: defaultLocation, map: map, draggable: true });

    google.maps.event.addListener(marker, 'dragend', function() {
        document.getElementById('latitude').value = marker.getPosition().lat();
        document.getElementById('longitude').value = marker.getPosition().lng();
    });

    document.getElementById('latitude').value = defaultLocation.lat;
    document.getElementById('longitude').value = defaultLocation.lng;
}

document.getElementById('current-location-btn').addEventListener('click', () => {
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(pos => {
            const coords = { lat: pos.coords.latitude, lng: pos.coords.longitude };
            map.setCenter(coords);
            marker.setPosition(coords);
            document.getElementById('latitude').value = coords.lat;
            document.getElementById('longitude').value = coords.lng;
        }, () => alert('Could not get your location.'));
    } else { alert('Geolocation is not supported by your browser.'); }
});

window.onload = initMap;

// Selection panel logic
const propertyTypePanel = document.getElementById('property-type-panel');
const startBtn = document.getElementById('start-form');
const editPanelBtn = document.getElementById('edit-panel');
const propertyTypeInput = document.getElementById('property_type_input');
const formContainer = document.getElementById('property-form-container');
const dynamicFields = document.getElementById('dynamic-fields');
const propertyTypeSelect = document.getElementById('initial-property-type');
const propertyTypeDescription = document.getElementById('property-type-description');

const propertyFields = {
    residential: ['bedrooms','bathrooms','floor_area','lot_size','year_built','floors','parking_spaces','balcony','heating_cooling','amenities'],
    commercial: ['floor_area','number_of_floors','parking_spaces','power_capacity','business_type','loading_docks','conference_rooms','accessibility_features'],
    industrial: ['total_area','power_capacity','ceiling_height','floor_load_capacity','crane_availability','access_roads','waste_disposal','safety_certifications'],
    land: ['land_size','zoning','road_frontage','utilities','soil_type']
};

const propertyDescriptions = {
    residential: "Homes or apartments suitable for living. Includes bedrooms, bathrooms, amenities, etc.",
    commercial: "Properties for business use like shops, offices, or retail spaces.",
    industrial: "Factories, warehouses, or facilities for manufacturing and production.",
    land: "Empty plots or land suitable for development, agriculture, or investment."
};

propertyTypeSelect.addEventListener('change', () => {
    const val = propertyTypeSelect.value;
    propertyTypeDescription.textContent = propertyDescriptions[val] || '';
});

startBtn.addEventListener('click', () => {
    const propType = propertyTypeSelect.value;
    if(!propType){ alert('Please select a Property Type'); return; }
    propertyTypeInput.value = propType;
    propertyTypePanel.classList.add('hidden');
    formContainer.classList.remove('hidden');
    dynamicFields.innerHTML = '';

    if(propertyFields[propType].length){
        const fields = propertyFields[propType];
        dynamicFields.innerHTML = `<h2 class="text-lg font-semibold text-[#1b5d38] mb-2 capitalize">${propType} Info</h2><div class="grid grid-cols-2 gap-4">` +
            fields.map(f => `<div>
                <label class="block text-gray-700 mb-1">${f.replace(/_/g,' ').replace(/\b\w/g, l => l.toUpperCase())}</label>
                <input type="text" name="${propType}[${f}]" class="w-full border border-gray-300 rounded-md p-2">
            </div>`).join('') + '</div>';
    }
});

editPanelBtn.addEventListener('click', () => {
    propertyTypePanel.classList.remove('hidden');
    formContainer.classList.add('hidden');
});

// Preview selected images
const imagesInput = document.getElementById('images');
const imagePreview = document.getElementById('image-preview');
imagesInput.addEventListener('change', () => {
    imagePreview.innerHTML = '';
    Array.from(imagesInput.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-24 object-cover rounded-md';
            imagePreview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

// Axios form submission
document.getElementById('property-ad-form').addEventListener('submit', function(e){
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    axios.post('/api/property/create', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    .then(res => { 
        alert('Property Ad created successfully!'); 
        form.reset(); 
        imagePreview.innerHTML = '';
        window.location.reload(); 
    })
    .catch(err => {
        console.error(err);
        if(err.response?.data?.errors){
            alert(JSON.stringify(err.response.data.errors));
        } else {
            alert('Failed to create property ad.');
        }
    });
});
</script>
@endsection
