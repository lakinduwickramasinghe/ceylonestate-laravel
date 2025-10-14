@extends('layouts.member')
@section('title','Member Dashboard - Ceylon Estate')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-[#1b5d38]">Member Dashboard</h1>
        <p class="text-sm text-gray-500">Overview of your listings and activity</p>
    </div>

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- My Property Ads -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500 uppercase font-semibold">My Property Ads</h3>
                    <p id="totalProperties" class="text-4xl font-bold text-[#1b5d38] mt-2">...</p>
                </div>
                <div class="bg-[#eaf5ef] p-3 rounded-full">
                    <i class="fas fa-home text-[#1b5d38] text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Unread Messages -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm text-gray-500 uppercase font-semibold">Unread Messages</h3>
                    <p id="unreadMessages" class="text-4xl font-bold text-[#1b5d38] mt-2">...</p>
                </div>
                <div class="bg-[#eaf5ef] p-3 rounded-full">
                    <i class="fas fa-envelope text-[#1b5d38] text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Small Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-sm text-gray-500 uppercase font-semibold mb-2">Activity Summary</h3>
            <canvas id="activityChart" height="100"></canvas>
        </div>
    </div>

    <!-- Latest Properties -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-[#1b5d38] mb-3 flex items-center">
            <i class="fas fa-building mr-2"></i> My Latest Property Ads
        </h3>
        <ul id="latestProperties" class="divide-y divide-gray-200"></ul>
    </div>

    <!-- Account Summary -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-[#1b5d38] mb-3 flex items-center">
            <i class="fas fa-user mr-2"></i> Account Overview
        </h3>
        <div class="space-y-1 text-gray-600">
            <p id="memberSince">Loading...</p>
            <p id="memberEmail">Loading...</p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", async () => {
    const userId = "{{ auth()->id() }}";
    const token = "{{ session('auth_token') }}";

    const totalPropertiesEl = document.getElementById("totalProperties");
    const unreadMessagesEl = document.getElementById("unreadMessages");
    const latestPropsEl = document.getElementById("latestProperties");
    const memberSinceEl = document.getElementById("memberSince");
    const memberEmailEl = document.getElementById("memberEmail");

    // Default placeholders
    totalPropertiesEl.innerText = "Loading...";
    unreadMessagesEl.innerText = "Loading...";
    memberSinceEl.innerText = "Loading...";
    memberEmailEl.innerText = "Loading...";

    try {
        // --- 1️⃣ Fetch properties
        const propRes = await axios.get(`/api/properties/member/${userId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });
        const properties = propRes.data.data || propRes.data;
        const propertyCount = properties.length;

        totalPropertiesEl.innerText = propertyCount;

        // Latest properties list
        latestPropsEl.innerHTML = "";
        if (propertyCount > 0) {
            properties.slice(0, 3).forEach(p => {
                const li = document.createElement("li");
                li.className = "py-2 flex justify-between";
                li.innerHTML = `
                    <span class="font-medium text-gray-700">${p.title}</span>
                    <span class="text-sm text-gray-500">${new Date(p.created_at).toLocaleDateString()}</span>
                `;
                latestPropsEl.appendChild(li);
            });
        } else {
            latestPropsEl.innerHTML = `<li class="text-gray-500 text-sm py-2">No properties found</li>`;
        }

        // --- 2️⃣ Fetch unread messages (notifications)
        let unreadCount = 0;
        try {
            const notifRes = await axios.get(`/api/notification/user/${userId}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            const notifications = notifRes.data.data || notifRes.data;
            unreadCount = notifications.filter(n => !n.read_at).length;
        } catch {
            // Silent fail if notification route missing
        }
        unreadMessagesEl.innerText = unreadCount;

        // --- 3️⃣ Fetch user info
        const userRes = await axios.get(`/api/users/${userId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });
        const user = userRes.data;
        memberSinceEl.innerText = "Member since: " + new Date(user.created_at).toLocaleDateString();
        memberEmailEl.innerText = "Email: " + user.email;

        // --- 4️⃣ Chart visualization
        const ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Properties', 'Messages'],
                datasets: [{
                    data: [propertyCount, unreadCount],
                    backgroundColor: ['#1b5d38', '#a7f3d0'],
                    borderRadius: 8
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });

    } catch (err) {
        console.error("Error loading member dashboard:", err);
        totalPropertiesEl.innerText = "Error";
        unreadMessagesEl.innerText = "Error";
        latestPropsEl.innerHTML = `<li class="text-red-500 text-sm py-2">Failed to load data</li>`;
    }
});
</script>
@endsection
