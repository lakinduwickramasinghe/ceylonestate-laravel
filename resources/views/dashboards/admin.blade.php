@extends('layouts.admin')
@section('title','Admin Dashboard - Ceylon Estate')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- Total Properties -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700">Total Property Ads</h3>
        <p class="text-3xl font-bold text-[#1b5d38] mt-2">245</p>
    </div>

    <!-- Users -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700">Registered Members</h3>
        <p class="text-3xl font-bold text-[#1b5d38] mt-2">120</p>
    </div>

    <!-- Payments -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700">Payments Collected</h3>
        <p class="text-3xl font-bold text-[#1b5d38] mt-2">Rs. 1,250,000</p>
    </div>

    <!-- Recent Listings -->
    <div class="bg-white shadow rounded-lg p-5 col-span-2">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Latest Property Ads</h3>
        <ul class="divide-y divide-gray-200">
            <li class="py-2 flex justify-between">
                <span>Luxury Villa in Colombo</span>
                <span class="text-sm text-gray-500">2025-09-01</span>
            </li>
            <li class="py-2 flex justify-between">
                <span>Commercial Building in Kandy</span>
                <span class="text-sm text-gray-500">2025-08-28</span>
            </li>
            <li class="py-2 flex justify-between">
                <span>Land for Sale in Galle</span>
                <span class="text-sm text-gray-500">2025-08-20</span>
            </li>
        </ul>
    </div>

    <!-- Notifications -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Unread Notifications</h3>
        <ul class="space-y-2 text-sm">
            <li class="flex items-center justify-between">
                <span>New payment received</span>
                <span class="text-xs text-gray-500">2 hours ago</span>
            </li>
            <li class="flex items-center justify-between">
                <span>3 new member registrations</span>
                <span class="text-xs text-gray-500">1 day ago</span>
            </li>
        </ul>
    </div>

</div>
@endsection
