<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties - Ceylon Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>
<body class="bg-gray-50 font-sans">

@include('layouts.header')

<!-- Hero Banner -->
<section class="h-[250px] flex items-center justify-center text-white relative"
         style="background-image: url('{{ asset('./images/hero.jpg') }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <h1 class="relative text-4xl md:text-5xl font-bold">Explore Properties</h1>
</section>

<!-- Main Content -->
<section class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row gap-10">

    <!-- Filters Sidebar -->
    <aside class="w-full md:w-1/4 bg-white shadow rounded-lg p-6 h-fit">
        <h2 class="text-lg font-semibold mb-4">Filter Properties</h2>
        
        <form id="filter-form" class="space-y-4">
            <!-- Keyword -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Keyword</label>
                <input type="text" name="keyword" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Search title or description">
            </div>

            <!-- Property Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Property Type</label>
                <select name="property_type" id="property_type" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Any</option>
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                    <option value="land">Land</option>
                    <option value="industrial">Industrial</option>
                </select>
            </div>

            <!-- Common Filters -->
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" name="city" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Province</label>
                <input type="text" name="province" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Min Price (LKR)</label>
                    <input type="number" name="price_min" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Max Price (LKR)</label>
                    <input type="number" name="price_max" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
            </div>

            <!-- Type-specific filters -->
            <div id="type-filters" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

            <button type="submit" class="w-full bg-[#1b5d38] hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold transition">
                Apply Filters
            </button>
        </form>
    </aside>

    <!-- Properties Grid -->
    <main class="flex-1">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">All Properties</h2>
        <div id="properties-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Properties will be injected here by JS -->
        </div>
        <!-- Pagination -->
        <div id="pagination" class="flex justify-center mt-10 space-x-2"></div>
    </main>
</section>

@include('layouts.footer')

<script>
let allProperties = [];

function renderTypeSpecificFilters(type) {
    const container = document.getElementById('type-filters');
    container.innerHTML = '';
    if (!type) return;

    const fields = {
        commercial: [
            { label: 'Floor Area', name: 'floor_area', type: 'number' },
            { label: 'Parking Spaces', name: 'parking_spaces', type: 'number' },
            { label: 'Business Type', name: 'business_type', type: 'text' },
            { label: 'Loading Docks', name: 'loading_docks', type: 'number' }
        ],
        land: [
            { label: 'Land Size', name: 'land_size', type: 'number' },
            { label: 'Road Frontage', name: 'road_frontage', type: 'number' },
            { label: 'Zoning', name: 'zoning', type: 'text' }
        ],
        residential: [
            { label: 'Bedrooms', name: 'bedrooms', type: 'number' },
            { label: 'Bathrooms', name: 'bathrooms', type: 'number' },
            { label: 'Floor Area', name: 'floor_area', type: 'number' },
            { label: 'Year Built', name: 'year_built', type: 'number' },
            { label: 'Balcony', name: 'balcony', type: 'text' }
        ],
        industrial: [
            { label: 'Total Area', name: 'total_area', type: 'number' },
            { label: 'Power Capacity', name: 'power_capacity', type: 'number' },
            { label: 'Ceiling Height', name: 'ceiling_height', type: 'number' },
            { label: 'Crane Availability', name: 'crane_availability', type: 'text' },
            { label: 'Access Roads', name: 'access_roads', type: 'text' }
        ]
    };

    fields[type].forEach(f => {
        const div = document.createElement('div');
        div.className = 'flex flex-col';
        div.innerHTML = `
            <label class="text-sm font-medium text-gray-700 mb-1">${f.label}</label>
            <input type="${f.type}" name="${f.name}" class="border border-gray-300 rounded px-3 py-2 w-full">
        `;
        container.appendChild(div);
    });
}

document.getElementById('property_type').addEventListener('change', (e) => {
    renderTypeSpecificFilters(e.target.value);
});

function fetchAllProperties() {
    axios.get('/api/property')
        .then(res => { allProperties = res.data.data; renderProperties(allProperties); })
        .catch(err => console.error(err));
}

function renderProperties(properties) {
    const grid = document.getElementById('properties-grid');
    grid.innerHTML = '';
    if (!properties.length) {
        grid.innerHTML = '<p class="col-span-3 text-center text-gray-500">No properties found.</p>';
        return;
    }

    properties.forEach(property => {
        let mainImage = property.images.find(img => img.is_main) || property.images[0];
        let imagePath = mainImage 
            ? `/property_images/${mainImage.imagepath.split('/').pop()}` 
            : '/images/default-property.jpg';

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
}

document.getElementById('filter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = Object.fromEntries(new FormData(this).entries());
    const filtered = allProperties.filter(p => {
        // Common filters
        if (formData.keyword && !p.title.toLowerCase().includes(formData.keyword.toLowerCase()) && !p.description.toLowerCase().includes(formData.keyword.toLowerCase())) return false;
        if (formData.property_type && p.property_type !== formData.property_type) return false;
        if (formData.city && !p.city.toLowerCase().includes(formData.city.toLowerCase())) return false;
        if (formData.province && !p.province.toLowerCase().includes(formData.province.toLowerCase())) return false;
        if (formData.price_min && p.price < formData.price_min) return false;
        if (formData.price_max && p.price > formData.price_max) return false;

        // Type-specific filters
        const type = p.property_type;
        const typeData = p[type] || {};
        for (let key in formData) {
            if (['keyword','property_type','city','province','price_min','price_max'].includes(key)) continue;
            if (formData[key] && (typeData[key] == null || typeData[key].toString().toLowerCase().indexOf(formData[key].toString().toLowerCase()) === -1)) return false;
        }
        return true;
    });
    renderProperties(filtered);
});

document.addEventListener('DOMContentLoaded', fetchAllProperties);
</script>

</body>
</html>
