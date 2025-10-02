@extends('layouts.member')
@section('title','Create Property Ad - Member Dashboard')
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
                    <div class="relative">
                        <input type="text" name="title" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>
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
                    <div class="relative">
                        <input type="text" name="address_line_1" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>
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

        <!-- Static Property Fields -->
        <div id="property-fields" class="bg-white p-6 rounded-lg shadow mb-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-[#1b5d38] mb-2">Property Details</h2>
            
            <!-- Residential -->
<div class="type-residential grid grid-cols-2 gap-6 hidden">

    <!-- Bedrooms -->
    <div class="relative">
        <label class="font-medium">Number of Bedrooms</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Bedroom SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><path fill="currentColor" d="M7.814 13.163c-.049-1.127-.71-2.048-1.835-2.13Q5.556 11.002 5 11c-.556-.002-.696.013-.979.033c-1.125.082-1.786 1.003-1.835 2.13C2.101 15.118 2 19.103 2 27s.101 11.882.186 13.837c.049 1.127.71 2.048 1.835 2.13q.423.032.979.033c.556.001.696-.012.979-.033c1.125-.082 1.786-1.003 1.835-2.13c.045-1.029.094-2.62.13-5.048q.088.009.177.012C10.195 35.888 14.672 36 24 36s13.805-.111 15.88-.199q.086-.003.17-.012c.037 2.427.086 4.018.13 5.047c.05 1.127.71 2.049 1.836 2.13q.423.033.979.034q.556-.002.979-.033c1.125-.082 1.786-1.004 1.835-2.131c.064-1.488.138-4.154.17-8.827A1.997 1.997 0 0 0 43.982 30H40v.17a3 3 0 0 0-.995-.17H24c-9.328 0-13.805.112-15.88.199l-.126.007Q8 28.723 8 27c0-7.896-.101-11.882-.186-13.837"/><path fill="currentColor" d="M21.22 16.523c.131-1.37 1.254-2.4 2.63-2.457c4.874-.203 9.385.091 13.047.518C42.31 15.216 46 19.971 46 25.421V26a2 2 0 0 1-2 2H23.195c-.974 0-1.8-.7-1.907-1.668A48 48 0 0 1 21 21.1c0-1.79.105-3.377.22-4.577M19 23.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0"/></svg>
            </div>
            <input type="number" min="0" name="residential[bedrooms]" class="w-full border rounded-md p-2 pl-12" placeholder="e.g. 3">
        </div>
    </div>

    <!-- Bathrooms -->
    <div class="relative">
        <label class="font-medium">Number of Bathrooms</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Bathroom SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M7 6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5a2 2 0 0 0-2-2H8a3 3 0 0 0-3 3v5H4a2 2 0 0 0-2 2v1a6 6 0 0 0 2.625 4.961l-.332.332a1 1 0 1 0 1.414 1.414l.876-.875c.454.11.929.168 1.417.168h8c.488 0 .963-.058 1.417-.168l.876.875a1 1 0 0 0 1.414-1.414l-.332-.332A6 6 0 0 0 22 14v-1a2 2 0 0 0-2-2H7z"/></g></svg>
            </div>
            <input type="number" min="0" step="0.5" name="residential[bathrooms]" class="w-full border rounded-md p-2 pl-12" placeholder="e.g. 2.5">
        </div>
    </div>

    <!-- Floor Area -->
    <div class="relative">
        <label class="font-medium">Floor Area</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-4 h-4 text-gray-400">
                <!-- Floor Area SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="M10 .5h4.5v14H.5V.5h4l3 2m-1 12v-7M4 7.5h5m3 0h2.5" stroke-width="1"/></svg>
            </div>
            <input type="number" min="0" step="0.1" name="residential[floor_area]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">sqft</span>
        </div>
    </div>

    <!-- Lot Size -->
    <div class="relative">
        <label class="font-medium">Lot Size</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Lot Size SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 8l6-3l-6-3v10"/><path d="m8 11.99l-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12m-9.51.85l11.02 6.3m0-6.3L6.5 19.15"/></g></svg>
            </div>
            <input type="number" min="0" step="0.1" name="residential[lot_size]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">perches</span>
        </div>
    </div>

    <!-- Year Built -->
    <div class="relative">
        <label class="font-medium">Construction Year</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Year Built SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m13.783 15.172l2.121-2.121l5.996 5.996l-2.121 2.121zM17.5 10c1.93 0 3.5-1.57 3.5-3.5c0-.58-.16-1.12-.41-1.6l-2.7 2.7l-1.49-1.49l2.7-2.7c-.48-.25-1.02-.41-1.6-.41C15.57 3 14 4.57 14 6.5c0 .41.08.8.21 1.16l-1.85 1.85l-1.78-1.78l.71-.71l-1.41-1.41L12 3.49a3 3 0 0 0-4.24 0L4.22 7.03l1.41 1.41H2.81l-.71.71l3.54 3.54l.71-.71V9.15l1.41 1.41l.71-.71l1.78 1.78l-7.41 7.41l2.12 2.12L16.34 9.79c.36.13.75.21 1.16.21"/></svg>
            </div>
            <input type="number" min="1800" max="2099" step="1" name="residential[year_built]" class="w-full border rounded-md p-2 pl-10" placeholder="YYYY">
        </div>
    </div>

    <!-- Floors -->
    <div class="relative">
        <label class="font-medium">Total Floors</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Floors SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 22v-2h3.5v-4.5H11V11h4.5V6.5H20V3h2v5.5h-4.5V13H13v4.5H8.5V22z"/></svg>
            </div>
            <input type="number" min="0" name="residential[floors]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. 2">
        </div>
    </div>

    <!-- Parking Spaces -->
    <div class="relative">
        <label class="font-medium">Parking Spaces Available</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Parking SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M1 1h14v14H1zm8 3H5v8h2v-2h2a3 3 0 1 0 0-6"/></g></svg>
            </div>
            <input type="number" min="0" name="residential[parking_spaces]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. 1">
        </div>
    </div>

    <!-- Balcony -->
    <div>
        <label class="font-medium">Balcony Available?</label>
        <div class="relative flex items-center gap-2">
            <div class="w-6 h-6 text-gray-400">
                <!-- Balcony SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 13v8m4-8v8m8-8v8m-4-8v8m8-8v8M2 21h20M2 13h20m-4-3V3.6a.6.6 0 0 0-.6-.6H6.6a.6.6 0 0 0-.6.6V10"/></svg>
            </div>
            <select name="residential[balcony]" class="w-full border rounded-md p-2">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
    </div>

    <!-- Heating/Cooling -->
    <div>
        <label class="font-medium">Heating / Cooling System</label>
        <div class="relative flex items-center gap-2">
            <div class="w-6 h-6 text-gray-400">
                <!-- Heating/Cooling SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7.425 4.15q.5-.35 1.038-.088T9 4.95v.525q0 .625.45 1.063t1.075.437q.35 0 .65-.15t.5-.425q.125-.175.35-.213t.425.088q.65.425 1.125 1.013T14.4 8.55q.2.375.05.75t-.525.575t-.763.063t-.587-.513q-.125-.25-.237-.437T12.05 8.6q-.35.2-.737.288t-.788.087q-1.1 0-1.987-.612T7.25 6.724q-.95.925-1.6 2.063T5 11.25q0 .775.275 1.463t.75 1.212q.05-.5.288-.937T6.9 12.2l1.4-1.4q.275-.275.688-.275t.712.275l.95.925q.3.3.3.713t-.3.712q-.275.275-.687.288t-.713-.263l-.25-.25l-.7.7q-.125.125-.213.288T8 14.275q0 .125.025.213t.075.187q.15.35.063.7T7.8 16q-.5.5-1.175.488T5.4 16.05q-.375-.275-.7-.625t-.6-.725q-.525-.725-.812-1.612T3 11.25q0-2.425 1.3-4.112T7.425 4.15M13.5 15.9l-.5.5V21q0 .425-.288.713T12 22t-.712-.288T11 21v-2.6l-2.9 2.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7L18.9 7.7q.275-.275.7-.275t.7.275t.275.7t-.275.7L17.4 12H20q.425 0 .713.288T21 13t-.288.713T20 14h-4.6l-.5.5l1.5 1.5H20q.425 0 .713.288T21 17t-.288.713T20 18h-1.6l1.4 1.4q.275.275.275.7t-.275.7t-.7.275t-.7-.275L17 19.4V21q0 .425-.288.713T16 22t-.712-.288T15 21v-3.6z"/></svg>
            </div>
            <select name="residential[heating_cooling]" class="w-full border rounded-md p-2">
                <option value="">Select system</option>
                <option value="Central AC">Central AC</option>
                <option value="Heater">Heater</option>
                <option value="Split AC">Split AC</option>
                <option value="None">None</option>
            </select>
        </div>
    </div>

    <!-- Amenities -->
    <div class="col-span-2">
        <label class="font-medium">Select Amenities</label>
        <div id="amenities-tags" class="border rounded-md p-2 flex flex-wrap gap-2 min-h-[48px] cursor-text text-gray-400 items-center">
            <svg class="inline w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="m22 10.5l-9.117-7.678a1.37 1.37 0 0 0-1.765 0L2 10.5"/><path d="M20.5 5v10.5c0 2.828 0 4.243-.879 5.121c-.878.879-2.293.879-5.121.879h-5c-2.828 0-4.243 0-5.121-.879C3.5 19.743 3.5 18.328 3.5 15.5v-6"/><path d="M10.5 11.5h-1v1h1zm4 0h-1v1h1zm-4 4h-1v1h1zm4 0h-1v1h1z"/></g></svg>
            Click below to select amenities
        </div>
        <input type="hidden" name="residential[amenities]" id="amenities-json">
        <div class="grid grid-cols-3 gap-2 mt-2">
            <button type="button" class="option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Swimming Pool</button>
            <button type="button" class="option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Gym</button>
            <button type="button" class="option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Garden</button>
            <button type="button" class="option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Security</button>
            <button type="button" class="option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Playground</button>
        </div>
    </div>

</div>



            <!-- Commercial -->
    <div class="type-commercial grid grid-cols-2 gap-6 hidden">

    <!-- Floor Area -->
    <div class="relative">
        <label class="font-medium">Floor Area</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-4 h-4 text-gray-400">
                <!-- Floor Area SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="M10 .5h4.5v14H.5V.5h4l3 2m-1 12v-7M4 7.5h5m3 0h2.5" stroke-width="1"/></svg>
            </div>
            <input type="number" min="0" step="0.1" name="commercial[floor_area]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">sqft</span>
        </div>
    </div>

    <!-- Number of Floors -->
    <div class="relative">
        <label class="font-medium">Number of Floors</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Floors SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 22v-2h3.5v-4.5H11V11h4.5V6.5H20V3h2v5.5h-4.5V13H13v4.5H8.5V22z"/></svg>
            </div>
            <input type="number" min="0" name="commercial[number_of_floors]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. 2">
        </div>
    </div>

    <!-- Parking Spaces -->
    <div class="relative">
        <label class="font-medium">Parking Spaces</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Parking SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M1 1h14v14H1zm8 3H5v8h2v-2h2a3 3 0 1 0 0-6"/></g></svg>
            </div>
            <input type="number" min="0" name="commercial[parking_spaces]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. 5">
        </div>
    </div>

    <!-- Power Capacity -->
    <div class="relative">
        <label class="font-medium">Power Capacity</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Power SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path fill="currentColor" d="M439.6 0H204.9L55.4 256h149.5l-128 256l341.3-320H247.5z"/></svg>
            </div>
            <input type="number" min="0" step="0.1" name="commercial[power_capacity]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">kW</span>
        </div>
    </div>

    <!-- Business Type -->
    <div class="relative">
        <label class="font-medium">Business Type</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Business SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path fill="currentColor" d="M320 176V16H32v480h128v-96h32v96h288V176ZM112 432H80v-32h32Zm0-80H80v-32h32Zm0-80H80v-32h32Zm0-80H80v-32h32Zm0-80H80V80h32Zm128-32h32v32h-32Zm-48 272h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32V80h32Zm80 320h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32v-32h32Zm0-80h-32v-32h32zm176 272H320v-32h32v-32h-32v-48h32v-32h-32v-48h32v-32h-32v-32h128Z"/></svg>
            </div>
            <input type="text" name="commercial[business_type]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. Retail">
        </div>
    </div>

    <!-- Loading Docks -->
    <div class="relative">
        <label class="font-medium">Loading Docks</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Loading SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2M19 5l.001 9H5V5z"/></svg>
            </div>
            <input type="number" min="0" name="commercial[loading_docks]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. 2">
        </div>
    </div>

    <!-- Conference Rooms -->
    <div class="relative">
        <label class="font-medium">Conference Rooms</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Conference SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M15 11.25H9a3 3 0 0 1 6 0"/><path d="M9.75 6a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M6.75.75h10.5s3 0 3 3v4.5s0 3-3 3H6.75s-3 0-3-3v-4.5s0-3 3-3M2.25 18a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M8.25 23.25a4.25 4.25 0 0 0-7.5 0M17.25 18a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M23.25 23.25a4.25 4.25 0 0 0-7.5 0m-6-5.25a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0"/><path d="M15.75 23.25a4.25 4.25 0 0 0-7.5 0"/></g></svg>
            </div>
            <input type="number" min="0" name="commercial[conference_rooms]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. 3">
        </div>
    </div>

    <!-- Accessibility Features Tags -->
    <div class="col-span-2">
    <label class="font-medium">Accessibility Features</label>
    <div id="accessibility-tags" class="border rounded-md p-2 flex flex-wrap gap-2 min-h-[48px] cursor-text text-gray-400 items-center">
        <svg class="inline w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M9 2h6v2H9zM4 7h16v2H4zM2 14h20v2H2zM6 19h12v2H6z"/></g></svg>
        Click below to select accessibility features
    </div>
    <input type="hidden" name="commercial[accessibility_features]" id="accessibility-json">
    <div class="grid grid-cols-3 gap-2 mt-2">
        <button type="button" class="accessibility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-200">Wheelchair Access</button>
        <button type="button" class="accessibility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-200">Elevator</button>
        <button type="button" class="accessibility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-200">Accessible Parking</button>
        <button type="button" class="accessibility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-200">Braille Signage</button>
        <button type="button" class="accessibility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-200">Audio Assistance</button>
    </div>
</div>




</div>


            <!-- Industrial -->
<div class="type-industrial grid grid-cols-2 gap-6 hidden">

    <!-- Total Area -->
    <div class="relative">
        <label class="font-medium">Total Area</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-5 h-5 text-gray-400">
                <!-- Area SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                    <path fill="none" stroke="currentColor" d="M10 .5h4.5v14H.5V.5h4l3 2m-1 12v-7M4 7.5h5m3 0h2.5" stroke-width="1"/>
                </svg>
            </div>
            <input type="number" min="0" step="0.1" name="industrial[total_area]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">sqft</span>
        </div>
    </div>

    <!-- Power Capacity -->
    <div class="relative">
        <label class="font-medium">Power Capacity</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Power SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M439.6 0H204.9L55.4 256h149.5l-128 256l341.3-320H247.5z"/>
                </svg>
            </div>
            <input type="number" min="0" step="0.1" name="industrial[power_capacity]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">kW</span>
        </div>
    </div>

    <!-- Ceiling Height -->
    <div class="relative">
        <label class="font-medium">Ceiling Height</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-5 h-5 text-gray-400">
                <!-- Height SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 2v20M5 12h14"/>
                </svg>
            </div>
            <input type="number" min="0" step="0.1" name="industrial[ceiling_height]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">m</span>
        </div>
    </div>

    <!-- Floor Load Capacity -->
    <div class="relative">
        <label class="font-medium">Floor Load Capacity</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Load SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4 21h16v-2H4v2zm0-6h16v-2H4v2zm0-6h16V7H4v2z"/>
                </svg>
            </div>
            <input type="number" min="0" step="0.1" name="industrial[floor_load_capacity]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">kg/m²</span>
        </div>
    </div>

    <!-- Crane Availability -->
    <div class="relative">
        <label class="font-medium">Crane Availability</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Crane SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20 6V5a1 1 0 0 0-1-1H9V3H6v1H5v2h1v9H5v-2H3v2H2v2h1v4h2v-4h5v4h2v-4h1v-2h-1v-2h-2v2H9V6h8v4.62c-.47.17-.81.61-.81 1.14c0 .44.24.84.61 1.06V14h.62c.34 0 .61.28.61.62s-.27.62-.61.62c-.22 0-.42-.12-.53-.31a.62.62 0 0 0-.84-.22c-.3.16-.4.54-.23.84c.33.56.94.92 1.6.92c1.01 0 1.84-.83 1.84-1.85c0-.78-.5-1.48-1.23-1.74v-.06c.38-.22.62-.62.62-1.06c0-.46-.27-.85-.65-1.06V6zM8 13.66l-1 1v-1.42l1-1zm0-2.95l-1 1v-1.42l1-1zm-1-2V7.29l1-1v1.42z"/></svg>
            </div>
            <select name="industrial[crane_availability]" class="w-full border rounded-md p-2 pl-10">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>

    <!-- Waste Disposal -->
    <div class="relative">
        <label class="font-medium">Waste Disposal</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Waste SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                    <path fill="currentColor" d="M3 1h9v2H3V1zm1 3h7v9H4V4z"/>
                </svg>
            </div>
            <input type="text" name="industrial[waste_disposal]" class="w-full border rounded-md p-2 pl-10" placeholder="e.g. On-site, Outsourced">
        </div>
    </div>

    <!-- Access Roads Tag Select -->
    <div class="relative col-span-2">
        <label class="font-medium">Access Roads</label>
        <div id="roads-tags" class="border rounded-md p-2 flex flex-wrap gap-2 min-h-[48px] cursor-text text-gray-400 items-center">
            <svg class="inline w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor" d="M3 21h18v-2H3v2zm2-4h14v-2H5v2zm2-4h10v-2H7v2z"/>
            </svg>
            Click to select access roads
        </div>
        <input type="hidden" id="roads-json" name="industrial[access_roads]">

        <div class="grid grid-cols-2 gap-2 mt-2">
            <div class="road-option border rounded-md p-2 cursor-pointer hover:bg-green-100">Highway</div>
            <div class="road-option border rounded-md p-2 cursor-pointer hover:bg-green-100">Local Road</div>
            <div class="road-option border rounded-md p-2 cursor-pointer hover:bg-green-100">Private Road</div>
            <div class="road-option border rounded-md p-2 cursor-pointer hover:bg-green-100">Other</div>
        </div>
    </div>

    <!-- Safety Certifications Tag Select -->
    <div class="relative col-span-2">
        <label class="font-medium">Safety Certifications</label>
        <div id="safety-tags" class="border rounded-md p-2 flex flex-wrap gap-2 min-h-[48px] cursor-text text-gray-400 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 2L2 7v6c0 5 4 9 10 9s10-4 10-9V7z"/>
            </svg>
            Click to select certifications
        </div>
        <input type="hidden" id="safety-json" name="industrial[safety_certifications]">

        <div class="grid grid-cols-2 gap-2 mt-2">
            <div class="safety-option border rounded-md p-2 cursor-pointer hover:bg-green-100">ISO 9001</div>
            <div class="safety-option border rounded-md p-2 cursor-pointer hover:bg-green-100">ISO 14001</div>
            <div class="safety-option border rounded-md p-2 cursor-pointer hover:bg-green-100">ISO 45001</div>
            <div class="safety-option border rounded-md p-2 cursor-pointer hover:bg-green-100">OSHA</div>
            <div class="safety-option border rounded-md p-2 cursor-pointer hover:bg-green-100">NFPA</div>
            <div class="safety-option border rounded-md p-2 cursor-pointer hover:bg-green-100">Other</div>
        </div>
    </div>

</div>



            <!-- Land -->
<div class="type-land grid grid-cols-2 gap-6 hidden">

    <!-- Land Size -->
    <div class="relative">
        <label class="font-medium">Land Size</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Land Size SVG (reuse previous icon) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><path fill="currentColor" d="M..."/></svg>
            </div>
            <input type="number" min="0" step="0.01" name="land[land_size]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">sqft</span>
        </div>
    </div>

    <!-- Zoning -->
    <div>
        <label class="font-medium">Zoning</label>
        <div class="relative flex items-center gap-2">
            <div class="w-6 h-6 text-gray-400">
                <!-- Zoning SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M38.5 5.5h-29c-2.2 0-4 1.8-4 4v29c0 2.2 1.8 4 4 4h29c2.2 0 4-1.8 4-4v-29c0-2.2-1.8-4-4-4M24 42.5v-37m-12.341 0v1" stroke-width="1"/><path fill="none" stroke="currentColor" stroke-dasharray="0 0 2.059 2.059" stroke-linecap="round" stroke-linejoin="round" d="M11.659 8.559v31.912" stroke-width="1"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M11.659 41.5v1" stroke-width="1"/></svg>
            </div>
            <select name="land[zoning]" class="w-full border rounded-md p-2">
                <option value="">Select zoning</option>
                <option value="residential">Residential</option>
                <option value="commercial">Commercial</option>
                <option value="agricultural">Agricultural</option>
                <option value="industrial">Industrial</option>
                <option value="mixed">Mixed</option>
            </select>
        </div>
        <p class="text-gray-400 text-sm mt-1">Zoning defines the permitted land use (e.g., Residential, Commercial). Select the category that fits the property.</p>
    </div>

    <!-- Road Frontage -->
    <div class="relative">
        <label class="font-medium">Road Frontage</label>
        <div class="relative">
            <div class="absolute left-2 top-2 w-6 h-6 text-gray-400">
                <!-- Road Frontage SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15 15.26V13h-4l4-4h-3l3-3h-2l3-3l3 3h-2l3 3h-3l4 4h-4v2.76c2.13.71 3.68 1.91 4 3.24c-1.7-.13-3.38-.46-5-1c-1.21.61-2.63 1-4 1c-1.29 0-2.83-.42-4-1c-1.63.54-3.28.87-5 1c.54-2.23 4.4-4 9-4c1.05 0 2.06.09 3 .26M8 19s-3 1-6 1v2c3 0 6-1 6-1s2 1 4 1s4-1 4-1s3 1 6 1v-2c-3 0-6-1-6-1s-2 1-4 1s-4-1-4-1"/></svg>
            </div>
            <input type="number" min="0" step="0.01" name="land[road_frontage]" class="w-full border rounded-md p-2 pl-10 pr-16" placeholder="Enter value">
            <span class="absolute right-2 top-2 text-gray-500 font-medium">meters</span>
        </div>
    </div>

    <!-- Utilities -->
    <div class="col-span-2">
        <label class="font-medium">Utilities</label>
        <div id="utilities-tags" class="border rounded-md p-2 flex flex-wrap gap-2 min-h-[48px] cursor-text text-gray-400 items-center">
            <svg class="inline w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M2 5h20M3 3v2m4-2v2m10-2v2m4-2v2m-2 0l-7 7l-7-7"/></svg>
            Click below to select utilities
        </div>
        <input type="hidden" name="land[utilities]" id="utilities-json">
        <div class="grid grid-cols-3 gap-2 mt-2">
            <button type="button" class="utility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Electricity</button>
            <button type="button" class="utility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Water</button>
            <button type="button" class="utility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Sewage</button>
            <button type="button" class="utility-option p-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-200">Internet</button>
        </div>
    </div>

    <!-- Soil Type -->
    <div>
        <label class="font-medium">Soil Type</label>
        <div class="relative flex items-center gap-2">
            <div class="w-6 h-6 text-gray-400">
                <!-- Soil Type SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M2 12h4m11 0h5M3 20.01l.01-.011M6 16.01l.01-.011M9 20.01l.01-.011M12 16.01l.01-.011M15 20.01l.01-.011M18 16.01l.01-.011M21 20.01l.01-.011M9 13s.9-3.741 3-6"/><path d="m16.186 2.241l.374 3.89c.243 2.523-1.649 4.77-4.172 5.012c-2.475.238-4.718-1.571-4.956-4.047a4.503 4.503 0 0 1 4.05-4.914l4.147-.4a.51.51 0 0 1 .557.46"/></g></svg>
            </div>
            <select name="land[soil_type]" class="w-full border rounded-md p-2">
                <option value="">Select soil type</option>
                <option value="clay">Clay</option>
                <option value="sandy">Sandy</option>
                <option value="loamy">Loamy</option>
                <option value="peaty">Peaty</option>
                <option value="silty">Silty</option>
                <option value="chalky">Chalky</option>
            </select>
        </div>
    </div>

</div>




        </div>

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
const propertyTypeSelect = document.getElementById('initial-property-type');
const propertyTypeDescription = document.getElementById('property-type-description');

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
    document.querySelectorAll('#property-fields > div').forEach(div => div.classList.add('hidden'));
    document.querySelectorAll('.type-' + propType).forEach(div => div.classList.remove('hidden'));
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

    axios.post('/api/property/create', formData,{
            headers: {
            Authorization: `Bearer {{ session('auth_token') }}`}
        })
    .then(async res => { 
        alert('Property Ad created successfully!'); 
        form.reset(); 
        imagePreview.innerHTML = '';

        // Create a notification
        try {
            const newNotification = {
                user_id: {{ Auth::id() }}, // current user
                title: `Your Property "${formData.get('title')}" has been created`,
                content: `Your new property "${formData.get('title')}" has been successfully created and is now listed in the system.`,
                type: 'property',
                ref: String(res.data.id) // convert to string
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

        window.location.href = `/property`; 
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

// Amenities tag selection logic [residential propery]
const amenitiesTags = document.getElementById('amenities-tags');
const amenitiesJson = document.getElementById('amenities-json');
const options = document.querySelectorAll('.option');

let selectedAmenities = [];

function updateAmenities() {
    amenitiesTags.innerHTML = '';
    selectedAmenities.forEach((item, index) => {
        const tag = document.createElement('div');
        tag.className = 'bg-blue-100 text-blue-800 px-2 py-1 rounded flex items-center gap-1';
        tag.innerHTML = `${item} <span class="cursor-pointer" onclick="removeAmenity(${index})">×</span>`;
        amenitiesTags.appendChild(tag);
    });
    amenitiesJson.value = JSON.stringify(selectedAmenities);
}

function removeAmenity(index) {
    selectedAmenities.splice(index, 1);
    updateAmenities();
}

options.forEach(option => {
    option.addEventListener('click', () => {
        if (!selectedAmenities.includes(option.innerText)) {
            selectedAmenities.push(option.innerText);
            updateAmenities();
        }
    });
});


// commercial property
const accessibilityTags = document.getElementById('accessibility-tags');
const accessibilityJson = document.getElementById('accessibility-json');
const accessibilityOptions = document.querySelectorAll('.accessibility-option');

let selectedAccessibility = [];

function updateAccessibility() {
    accessibilityTags.innerHTML = '';
    selectedAccessibility.forEach((item, index) => {
        const tag = document.createElement('div');
        tag.className = 'bg-green-100 text-green-800 px-2 py-1 rounded flex items-center gap-1';
        tag.innerHTML = `${item} <span class="cursor-pointer" onclick="removeAccessibility(${index})">×</span>`;
        accessibilityTags.appendChild(tag);
    });
    accessibilityJson.value = JSON.stringify(selectedAccessibility);
}

function removeAccessibility(index) {
    selectedAccessibility.splice(index, 1);
    updateAccessibility();
}

accessibilityOptions.forEach(option => {
    option.addEventListener('click', () => {
        if (!selectedAccessibility.includes(option.innerText)) {
            selectedAccessibility.push(option.innerText);
            updateAccessibility();
        }
    });
});


// Industrial property
// ----- Safety Certifications -----
const safetyTags = document.getElementById('safety-tags');
const safetyJson = document.getElementById('safety-json');
const safetyOptions = document.querySelectorAll('.safety-option');

let selectedSafety = [];

function updateSafety() {
    safetyTags.innerHTML = '';
    selectedSafety.forEach((item, index) => {
        const tag = document.createElement('div');
        tag.className = 'bg-green-100 text-green-800 px-2 py-1 rounded flex items-center gap-1';
        tag.innerHTML = `${item} <span class="cursor-pointer" onclick="removeSafety(${index})">×</span>`;
        safetyTags.appendChild(tag);
    });
    safetyJson.value = JSON.stringify(selectedSafety);
}

function removeSafety(index) {
    selectedSafety.splice(index, 1);
    updateSafety();
}

safetyOptions.forEach(option => {
    option.addEventListener('click', () => {
        if (!selectedSafety.includes(option.innerText)) {
            selectedSafety.push(option.innerText);
            updateSafety();
        }
    });
});

// ----- Access Roads -----
const roadsTags = document.getElementById('roads-tags');
const roadsJson = document.getElementById('roads-json');
const roadOptions = document.querySelectorAll('.road-option');

let selectedRoads = [];

function updateRoads() {
    roadsTags.innerHTML = '';
    selectedRoads.forEach((item, index) => {
        const tag = document.createElement('div');
        tag.className = 'bg-green-100 text-green-800 px-2 py-1 rounded flex items-center gap-1';
        tag.innerHTML = `${item} <span class="cursor-pointer" onclick="removeRoad(${index})">×</span>`;
        roadsTags.appendChild(tag);
    });
    roadsJson.value = JSON.stringify(selectedRoads);
}

function removeRoad(index) {
    selectedRoads.splice(index, 1);
    updateRoads();
}

roadOptions.forEach(option => {
    option.addEventListener('click', () => {
        if (!selectedRoads.includes(option.innerText)) {
            selectedRoads.push(option.innerText);
            updateRoads();
        }
    });
});

// land 

// Utilities tag select
document.addEventListener("DOMContentLoaded", function() {
    const utilitiesContainer = document.getElementById('utilities-tags');
    const utilitiesHidden = document.getElementById('utilities-json');
    const options = document.querySelectorAll('.utility-option');

    let selectedUtilities = [];

    function updateUtilitiesInput() {
        utilitiesHidden.value = JSON.stringify(selectedUtilities);
        utilitiesContainer.innerHTML = ''; // Clear existing tags
        selectedUtilities.forEach(util => {
            const tag = document.createElement('span');
            tag.className = 'bg-blue-100 text-blue-800 px-2 py-1 rounded-full flex items-center gap-1';
            tag.textContent = util;

            // remove button
            const removeBtn = document.createElement('span');
            removeBtn.className = 'cursor-pointer';
            removeBtn.innerHTML = '&times;';
            removeBtn.addEventListener('click', () => {
                selectedUtilities = selectedUtilities.filter(u => u !== util);
                updateUtilitiesInput();
            });

            tag.appendChild(removeBtn);
            utilitiesContainer.appendChild(tag);
        });

        // Placeholder text if nothing selected
        if(selectedUtilities.length === 0){
            const placeholder = document.createElement('span');
            placeholder.className = 'text-gray-400 flex items-center gap-1';
            placeholder.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M2 5h20M3 3v2m4-2v2m10-2v2m4-2v2m-2 0l-7 7l-7-7"/></svg> Click to select utilities`;
            utilitiesContainer.appendChild(placeholder);
        }
    }

    options.forEach(option => {
        option.addEventListener('click', () => {
            const value = option.textContent.trim();
            if(!selectedUtilities.includes(value)){
                selectedUtilities.push(value);
                updateUtilitiesInput();
            }
        });
    });

    // initialize
    updateUtilitiesInput();
});

</script>
@endsection
