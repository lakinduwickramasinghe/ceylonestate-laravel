@extends('layouts.member')

@section('title','My Properties - Member Panel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-[#1b5d38]">My Property Ads</h1>
    <a href="{{route('property.create')}}" class="bg-[#1b5d38] text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Add New Property</a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200" id="member-properties-table">
        <thead class="bg-[#1b5d38]">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Created At</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="member-properties-body">
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Loading your properties...</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="mt-4" id="member-pagination"></div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('member-properties-body');
    const paginationDiv = document.getElementById('member-pagination');
    const userId = {{ Auth::id() }}; // Logged-in user ID

    function fetchMemberProperties(page = 1) {
        axios.get(`/api/property/member/${userId}?page=${page}`)
            .then(response => {
                tableBody.innerHTML = '';

                // Show friendly message if API returns a message field
                if (response.data.message) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">You have no listings yet.</td></tr>`;
                    paginationDiv.innerHTML = '';
                    return;
                }

                const data = response.data.data || response.data;

                // Safety check if data is empty array
                if (!data || data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">You have no listings yet.</td></tr>`;
                    paginationDiv.innerHTML = '';
                    return;
                }

                // Render property rows
                data.forEach(property => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${property.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${property.title}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${property.property_type ? property.property_type.charAt(0).toUpperCase() + property.property_type.slice(1) : ''}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${property.status ? property.status.charAt(0).toUpperCase() + property.status.slice(1) : ''}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${new Date(property.created_at).toLocaleDateString()}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                            <a href="/property/${property.id}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a>
                            <a href="/property/${property.id}/edit" class="text-green-600 hover:text-green-800"><i class="fas fa-edit"></i></a>
                            <button onclick="deleteMemberProperty(${property.id})" class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Pagination if provided
                if (response.data.links) {
                    const links = response.data.links;
                    paginationDiv.innerHTML = '';
                    links.forEach(link => {
                        if (link.url) {
                            const btn = document.createElement('button');
                            btn.innerHTML = link.label.replace('&laquo;', '«').replace('&raquo;', '»');
                            btn.className = `px-3 py-1 mx-1 rounded ${link.active ? 'bg-[#1b5d38] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`;
                            btn.addEventListener('click', () => fetchMemberProperties(link.url.split('page=')[1]));
                            paginationDiv.appendChild(btn);
                        }
                    });
                }

            })
            .catch(error => {
                console.error(error);
                tableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">Failed to load your properties.</td></tr>`;
            });
    }

    fetchMemberProperties();
});

// Delete property
function deleteMemberProperty(id) {
    if (!confirm('Are you sure you want to delete this property?')) return;

    axios.delete(`/api/property/${id}`)
        .then(() => {
            alert('Property deleted successfully.');
            location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Failed to delete property.');
        });
}

</script>
@endsection
