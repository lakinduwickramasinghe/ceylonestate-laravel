@extends('layouts.admin')

@section('title','View User - Admin Panel')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow border border-gray-200 p-6" id="user-container">
    <div class="text-center text-gray-500">Loading user details...</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('user-container');

    function fetchUser(userId) {
        axios.get(`/api/user/${userId}`)
            .then(response => {
                const user = response.data;

                // Build profile photo URL (storage if profile_photo_path exists, else profile_photo_url)
                const profilePhoto = user.profile_photo_path 
                    ? `{{ asset('storage') }}/${user.profile_photo_path}`
                    : user.profile_photo_url;

                container.innerHTML = `
                    <!-- Profile Header -->
                    <div class="flex items-center space-x-6 border-b border-gray-200 pb-4 mb-6">
                        <img src="${profilePhoto}" 
                             alt="Profile Photo" 
                             class="w-20 h-20 rounded-full shadow object-cover">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">${user.first_name} ${user.last_name}</h2>
                            <p class="text-gray-500 text-sm">@${user.username}</p>
                            <span class="mt-2 inline-block px-2 py-1 rounded-full text-xs font-medium 
                                ${user.role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'}">
                                ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                            </span>
                        </div>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="bg-gray-50 p-4 rounded border border-gray-100">
                            <h3 class="font-semibold text-gray-600 mb-1">Email</h3>
                            <p class="text-gray-800">${user.email}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border border-gray-100">
                            <h3 class="font-semibold text-gray-600 mb-1">Joined</h3>
                            <p class="text-gray-800">${new Date(user.created_at).toLocaleDateString()}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.user.index') }}" 
                           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium">
                           Back to Users
                        </a>
                        <button onclick="deleteUser(${user.id})" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium">
                            Delete User
                        </button>
                    </div>
                `;
            })
            .catch(error => {
                console.error(error);
                container.innerHTML = `<div class="text-center text-red-500">Failed to load user details.</div>`;
            });
    }

    function deleteUser(id) {
        if (!confirm('Are you sure you want to delete this user?')) return;

        axios.delete(`/api/user/${id}`)
            .then(() => {
                alert('User deleted successfully.');
                window.location.href = "{{ route('admin.user.index') }}";
            })
            .catch(err => {
                console.error(err);
                alert('Failed to delete user.');
            });
    }

    // User ID from route
    const userId = "{{ request()->route('id') }}"; 
    fetchUser(userId);
});
</script>
@endsection
