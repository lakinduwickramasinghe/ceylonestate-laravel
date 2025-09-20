@extends('layouts.member')

@section('title','Feedbacks - Admin Panel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-[#1b5d38]">Feedbacks</h1>
    <a href="{{ route('feedback.create') }}" 
       class="px-4 py-2 bg-[#1b5d38] text-white rounded-lg shadow hover:bg-[#154a2c]">
        + Create Feedback
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200" id="feedbacks-table">
        <thead class="bg-[#1b5d38]">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">User Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Rating</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Review</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="feedbacks-body">
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Loading feedbacks...</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('feedbacks-body');

    async function fetchUserName(userId) {
        try {
            const res = await axios.get(`/api/user/${userId}`,{
            headers: {
            Authorization: `Bearer {{ session('auth_token') }}`}
        });
            const user = res.data;
            return `${user.first_name} ${user.last_name}`;
        } catch (err) {
            console.error(err);
            return `User ${userId}`;
        }
    }

    function truncateMessage(msg, length = 50) {
        if (!msg) return '';
        return msg.length > length ? msg.slice(0, length) + '...' : msg;
    }

    async function fetchFeedbacks() {
        try {
            const userId = "{{ auth()->id() }}";
            const response = await axios.get(`/api/feedback/member/${userId}`,{
            headers: {
            Authorization: `Bearer {{ session('auth_token') }}`}
        });
            const data = response.data.data;
            tableBody.innerHTML = '';

            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No feedbacks found.</td></tr>`;
                return;
            }

            for (let i = 0; i < data.length; i++) {
                const feedback = data[i];
                const userName = await fetchUserName(feedback.userid);
                const truncatedMessage = truncateMessage(feedback.message, 50);

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${i + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${userName}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${feedback.rating}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${truncatedMessage}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                        <a href="/feedback/show/${feedback.id}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a>
                        <a href="/feedback/${feedback.id}/edit" class="text-green-600 hover:text-green-800"><i class="fas fa-edit"></i></a>
                        <button onclick="deleteFeedback('${feedback.id}')" class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
            }

        } catch (error) {
            console.error(error);
            tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">Failed to load feedbacks.</td></tr>`;
        }
    }

    fetchFeedbacks();
});

function deleteFeedback(id) {
    if (!confirm('Are you sure you want to delete this feedback?')) return;

    axios.delete(`/api/feedback/${id}`,{
            headers: {
            Authorization: `Bearer {{ session('auth_token') }}`}
        })
        .then(() => {
            alert('Feedback deleted successfully.');
            window.location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Failed to delete feedback.');
        });
}
</script>
@endsection
