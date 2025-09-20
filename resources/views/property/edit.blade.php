@extends('layouts.member')
@section('title','Edit Property - Admin Panel')

@section('content')
<div class="max-w-6xl mx-auto py-8 space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-[#1b5d38] flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#1b5d38]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
            </svg>
            Edit Property
        </h1>
        <a href="{{ route('property.index') }}" 
           class="px-4 py-2 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
            Back to List
        </a>
    </div>

    <!-- Form -->
    <form id="property-form" class="space-y-6" enctype="multipart/form-data">
        <div id="property-sections" class="space-y-6"></div>

        <!-- Images Section -->
        <div class="bg-white p-6 rounded-2xl shadow border border-gray-200">
            <h2 class="text-xl font-semibold text-[#1b5d38] mb-4">Property Images</h2>
            <div id="existing-images" class="grid grid-cols-4 gap-2 mb-4"></div>
            <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full border border-gray-300 rounded-md p-2">
            <div id="image-preview" class="mt-2 grid grid-cols-4 gap-2"></div>
        </div>

        <button type="submit" class="w-full bg-[#1b5d38] text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Save Changes
        </button>
    </form>

    <!-- Google Map -->
    <div class="bg-white p-6 rounded-2xl shadow border border-gray-200">
        <h2 class="text-xl font-semibold text-[#1b5d38] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#1b5d38]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4.5 8-11a8 8 0 10-16 0c0 6.5 8 11 8 11z" />
            </svg>
            Location
        </h2>
        <div id="map" class="w-full h-72 rounded-xl border border-gray-300"></div>
    </div>
</div>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7Ryp7xCNU4eLnBO1SlK2sWldalQg_f3I&libraries=places"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const propertyId = "{{ $id }}";
    const container = document.getElementById('property-sections');
    const form = document.getElementById('property-form');
    const existingImagesContainer = document.getElementById('existing-images');
    const imagesInput = document.getElementById('images');
    const imagePreview = document.getElementById('image-preview');
    let propertyData = {};

    // Helpers
    function inputField(name, label, value = "", type = "text") {
        return `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">${label}</label>
                <input type="${type}" name="${name}" value="${value ?? ''}" 
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-[#1b5d38]" />
            </div>
        `;
    }

    function textareaField(name, label, value = "") {
        return `
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">${label}</label>
                <textarea name="${name}" rows="3" 
                          class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-[#1b5d38]">${value ?? ''}</textarea>
            </div>
        `;
    }

    function section(title, body) {
        return `
            <div class="bg-white p-6 rounded-2xl shadow border border-gray-200">
                <h2 class="text-xl font-semibold text-[#1b5d38] mb-4">${title}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">${body}</div>
            </div>
        `;
    }

    function renderSections(data) {
        let html = '';

        // Basic Info
        html += section("Basic Info",
            inputField("title", "Title", data.title) +
            textareaField("description", "Description", data.description) +
            inputField("property_type", "Property Type", data.property_type) +
            inputField("listing_type", "Listing Type", data.listing_type) +
            inputField("status", "Status", data.status)
        );

        // Address
        html += section("Address Info",
            inputField("address_line_1", "Address Line 1", data.address_line_1) +
            inputField("address_line_2", "Address Line 2", data.address_line_2) +
            inputField("city", "City", data.city) +
            inputField("province", "Province", data.province) +
            inputField("postal_code", "Postal Code", data.postal_code) +
            inputField("latitude", "Latitude", data.latitude) +
            inputField("longitude", "Longitude", data.longitude)
        );

        // Price
        html += section("Price Info",
            inputField("price", "Price (LKR)", data.price, "number")
        );

        // Render dynamic fields (skip IDs/timestamps)
        const propertyTypes = ['residential','commercial','industrial','land','rental'];
        propertyTypes.forEach(type => {
            if(data[type]) {
                let fieldsHtml = '';
                Object.keys(data[type]).forEach(key => {
                    if(['id','property_id','created_at','updated_at'].includes(key)) return;
                    if(typeof data[type][key] === 'object') return;
                    if(['amenities','accessibility_features','lease_terms','utilities','conditions'].includes(key)){
                        fieldsHtml += textareaField(`${type}[${key}]`, key.replace(/_/g,' ').replace(/\b\w/g, l => l.toUpperCase()), data[type][key]);
                    } else {
                        fieldsHtml += inputField(`${type}[${key}]`, key.replace(/_/g,' ').replace(/\b\w/g, l => l.toUpperCase()), data[type][key]);
                    }
                });
                html += section(`${type.charAt(0).toUpperCase() + type.slice(1)} Info`, fieldsHtml);
            }
        });

        container.innerHTML = html;
    }

    function renderExistingImages(images) {
        existingImagesContainer.innerHTML = '';
        images.forEach(img => {
            const div = document.createElement('div');
            div.className = 'relative group';

            const image = document.createElement('img');
            image.src = '/' + img.imagepath;
            image.className = 'w-full h-24 object-cover rounded-md';

            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'main_image_id';
            radio.value = img.id;
            radio.checked = img.is_main;
            radio.className = 'absolute bottom-1 left-1 scale-125';

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.innerHTML = '&times;';
            deleteBtn.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition';
            deleteBtn.addEventListener('click', () => {
                if(confirm('Delete this image?')) {
                    axios.delete(`/api/property/image/${img.id}`)
                        .then(() => { div.remove(); })
                        .catch(() => alert('Failed to delete image.'));
                }
            });

            div.appendChild(image);
            div.appendChild(radio);
            div.appendChild(deleteBtn);
            existingImagesContainer.appendChild(div);
        });
    }

    function initMap(lat = 6.9271, lng = 79.8612) {
        const coords = { lat: parseFloat(lat), lng: parseFloat(lng) };
        const map = new google.maps.Map(document.getElementById("map"), { zoom: 13, center: coords });
        new google.maps.Marker({ position: coords, map: map });
    }

    // Preview new images
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

    // Load property
    axios.get(`/api/property/${propertyId}`)
        .then(res => {
            propertyData = res.data;
            renderSections(propertyData);
            renderExistingImages(propertyData.images || []);
            initMap(propertyData.latitude, propertyData.longitude);
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = `<div class="p-6 bg-red-50 text-red-600 rounded-md">Failed to load property data.</div>`;
        });

    // Save changes
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        formData.append('_method','PUT');

        axios.post(`/api/property/${propertyId}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then(() => alert("Property updated successfully."))
        .catch(err => {
            console.error(err);
            alert("Failed to update property.");
        });
    });
});
</script>
@endsection
