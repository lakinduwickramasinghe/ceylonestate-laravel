@extends('layouts.admin')

@section('title','Users - Admin Panel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-[#1b5d38]">Users</h1>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200" id="users-table">
        <thead class="bg-[#1b5d38]">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Username</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Full Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="users-body">
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Loading users...</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="mt-4" id="pagination"></div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('users-body');
    const paginationDiv = document.getElementById('pagination');

    function fetchUsers(page = 1) {
        axios.get(`/api/user`)
            .then(response => {
                const data = response.data.data;
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td></tr>`;
                    paginationDiv.innerHTML = '';
                    return;
                }

                data.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${user.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${user.username}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${user.first_name} ${user.last_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                            <a href="/admin/user/${user.id}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a>
                            <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Pagination
                const links = response.data.links;
                paginationDiv.innerHTML = '';
                links.forEach(link => {
                    if (link.url) {
                        const btn = document.createElement('button');
                        btn.innerHTML = link.label.replace('&laquo;', '«').replace('&raquo;', '»');
                        btn.className = `px-3 py-1 mx-1 rounded ${link.active ? 'bg-[#1b5d38] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`;
                        btn.addEventListener('click', () => fetchUsers(link.label === 'Previous' || link.label === '«' ? link.url.split('page=')[1] - 1 : link.label === 'Next' || link.label === '»' ? parseInt(link.url.split('page=')[1]) : link.url.split('page=')[1]));
                        paginationDiv.appendChild(btn);
                    }
                });

            })
            .catch(error => {
                console.error(error);
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">Failed to load users.</td></tr>`;
            });
    }

    fetchUsers();
});

function deleteUser(id) {
    if (!confirm('Are you sure you want to delete this user?')) return;

    axios.delete(`/api/user/${id}`)
        .then(() => {
            alert('User deleted successfully.');
            location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Failed to delete user.');
        });
}
</script>
@endsection
