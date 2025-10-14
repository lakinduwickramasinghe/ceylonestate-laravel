@extends('layouts.admin')
@section('title','Admin Dashboard - Ceylon Estate')

@section('content')
<div class="space-y-8">

    <!-- Dashboard Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-[#1b5d38]">Admin Dashboard</h1>
        <p class="text-sm text-gray-500">Overview of system stats and latest activity</p>
    </div>

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Properties -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-500 text-sm uppercase font-semibold">Total Property Ads</h3>
                    <p id="totalProperties" class="text-4xl font-bold text-[#1b5d38] mt-2">...</p>
                </div>
                <div class="bg-[#eaf5ef] p-3 rounded-full">
                    <i class="fas fa-home text-[#1b5d38] text-2xl"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-gray-600">
                <p id="availableProperties">Available: ...</p>
                <p id="soldProperties">Sold: ...</p>
            </div>
        </div>

        <!-- Users -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-500 text-sm uppercase font-semibold">Registered Members</h3>
                    <p id="totalUsers" class="text-4xl font-bold text-[#1b5d38] mt-2">...</p>
                </div>
                <div class="bg-[#eaf5ef] p-3 rounded-full">
                    <i class="fas fa-users text-[#1b5d38] text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-gray-500 text-sm uppercase font-semibold mb-2">Property Breakdown</h3>
            <canvas id="propertyChart" height="100"></canvas>
        </div>
    </div>

    <!-- Graph Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-gray-500 text-sm uppercase font-semibold mb-4">Properties Growth (Last 6 Entries)</h3>
        <canvas id="propertyTrendChart" height="100"></canvas>
    </div>

    <!-- Latest Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Properties -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-[#1b5d38] mb-3 flex items-center">
                <i class="fas fa-building mr-2"></i> Latest Property Ads
            </h3>
            <ul id="latestProperties" class="divide-y divide-gray-200"></ul>
        </div>

        <!-- Latest Users -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-[#1b5d38] mb-3 flex items-center">
                <i class="fas fa-user-plus mr-2"></i> Latest Registered Users
            </h3>
            <ul id="latestUsers" class="divide-y divide-gray-200"></ul>
        </div>
    </div>

</div>

<!-- Axios + Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
async function loadDashboard() {
    try {
        const token = "{{ auth()->user()->createToken('api-token')->plainTextToken }}";
        const { data } = await axios.get("{{ url('/api/dashboard') }}", {
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        });

        // Update stats
        document.getElementById('totalProperties').innerText = data.totalProperties;
        document.getElementById('availableProperties').innerText = "Available: " + data.availableProperties;
        document.getElementById('soldProperties').innerText = "Sold: " + data.soldProperties;
        document.getElementById('totalUsers').innerText = data.totalUsers;

        // Pie Chart (Available vs Sold)
        const ctx = document.getElementById('propertyChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'Sold'],
                datasets: [{
                    data: [data.availableProperties, data.soldProperties],
                    backgroundColor: ['#1b5d38', '#cbd5e1'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } },
                cutout: '70%'
            }
        });

        // Property Trend Chart (showing the last 6 entries)
        const trendCtx = document.getElementById('propertyTrendChart').getContext('2d');
        const latestProps = data.latestProperties.slice(0, 6).reverse();
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: latestProps.map(p => new Date(p.created_at).toISOString().split('T')[0]),
                datasets: [{
                    label: 'New Properties',
                    data: latestProps.map((p, i) => i + 1),
                    borderColor: '#1b5d38',
                    backgroundColor: 'rgba(27, 93, 56, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Latest Properties List
        const propertiesList = document.getElementById('latestProperties');
        propertiesList.innerHTML = '';
        data.latestProperties.forEach(p => {
            const li = document.createElement('li');
            li.className = "py-2 flex justify-between";
            li.innerHTML = `<span>${p.title}</span>
                            <span class="text-sm text-gray-500">${p.status} • ${new Date(p.created_at).toISOString().split('T')[0]}</span>`;
            propertiesList.appendChild(li);
        });

        // Latest Users List
        const usersList = document.getElementById('latestUsers');
        usersList.innerHTML = '';
        data.latestUsers.forEach(u => {
            const li = document.createElement('li');
            li.className = "py-2 flex justify-between";
            li.innerHTML = `<span>${u.name}</span>
                            <span class="text-sm text-gray-500">${u.email}</span>`;
            usersList.appendChild(li);
        });

    } catch (error) {
        console.error("Error loading dashboard:", error);
        alert("Failed to load dashboard data.");
    }
}

loadDashboard();
</script>
@endsection
