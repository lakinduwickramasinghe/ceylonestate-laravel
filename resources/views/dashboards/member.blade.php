@extends('layouts.member')
@section('title','Member Dashboard - Ceylon Estate')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- My Listings -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700">My Property Ads</h3>
        <p class="text-3xl font-bold text-[#1b5d38] mt-2">12</p>
    </div>

    <!-- Leads -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700">New Leads</h3>
        <p class="text-3xl font-bold text-[#1b5d38] mt-2">5</p>
    </div>

    <!-- Messages -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700">Unread Messages</h3>
        <p class="text-3xl font-bold text-[#1b5d38] mt-2">3</p>
    </div>

    <!-- Recent Ads -->
    <div class="bg-white shadow rounded-lg p-5 col-span-2">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">My Latest Property Ads</h3>
        <ul class="divide-y divide-gray-200">
            <li class="py-2 flex justify-between">
                <span>Modern Apartment in Colombo</span>
                <span class="text-sm text-gray-500">2025-09-05</span>
            </li>
            <li class="py-2 flex justify-between">
                <span>Beachfront Villa in Negombo</span>
                <span class="text-sm text-gray-500">2025-08-30</span>
            </li>
        </ul>
    </div>

    <!-- Account Overview -->
    <div class="bg-white shadow rounded-lg p-5">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Account Summary</h3>
        <p class="text-sm text-gray-600">Member since: 2023-06-10</p>
        <p class="text-sm text-gray-600">Email: member@example.com</p>
    </div>

</div>
@endsection
